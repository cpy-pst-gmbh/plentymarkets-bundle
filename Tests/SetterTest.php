<?php

namespace PM\PlentyMarketsBundle\Tests;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariation;
use PM\PlentyMarketsBundle\Component\Model\Order\StatusHistoryEntry;
use PM\PlentyMarketsBundle\Tests\Support\ModelClasses;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
use TypeError;

use function sprintf;
use function str_starts_with;

/**
 * Since #58 the properties of the models are typed, the setters kept their 1.x signatures. Every
 * value a setter takes must fit, or it fails with a TypeError.
 */
final class SetterTest extends TestCase
{
    /** @return iterable<string, array{class-string}> */
    public static function models(): iterable
    {
        foreach (ModelClasses::all() as $path => $class) {
            yield $path => [$class];
        }
    }

    /** @param class-string $class */
    #[DataProvider('models')]
    public function testEverySetterTakesWhatItsSignatureAllows(string $class): void
    {
        $reflection = new ReflectionClass($class);
        $failures = [];

        foreach ($reflection->getMethods() as $method) {
            if (!$method->isPublic() || $method->isStatic() || !str_starts_with($method->getName(), 'set') || 1 !== $method->getNumberOfParameters()) {
                continue;
            }

            $type = $method->getParameters()[0]->getType();
            foreach (null === $type ? [] : self::samples($type) as $label => $value) {
                try {
                    $method->invoke($reflection->newInstance(), $value);
                } catch (TypeError $error) {
                    $failures[] = sprintf('%s(%s): %s', $method->getName(), $label, $error->getMessage());
                }
            }
        }

        self::assertSame([], $failures, $class);
    }

    public function testAnImmutableCreationDateIsKept(): void
    {
        $entry = (new StatusHistoryEntry())->setCreatedAt(new DateTimeImmutable('2026-11-17T06:15:00+01:00'));

        self::assertInstanceOf(DateTime::class, $entry->getCreatedAt());
        self::assertSame('2026-11-17T06:15:00+01:00', $entry->getCreatedAt()->format(DATE_ATOM));
    }

    public function testADateTimeIsTakenAsItIs(): void
    {
        $date = new DateTime('2026-11-17T06:15:00+01:00');

        self::assertSame($date, (new StatusHistoryEntry())->setCreatedAt($date)->getCreatedAt());
    }

    public function testNoSuppliersOrCategoriesAreAnEmptyList(): void
    {
        $variation = (new ItemVariation())->setVariationSuppliers(null)->setVariationCategories(null);

        self::assertSame([], $variation->getVariationSuppliers());
        self::assertSame([], $variation->getVariationCategories());
    }

    /** @return array<string, mixed> a value for every type the parameter allows, by label */
    private static function samples(ReflectionType $type): array
    {
        $samples = [];
        if ($type->allowsNull()) {
            $samples['null'] = null;
        }

        foreach ($type instanceof ReflectionUnionType ? $type->getTypes() : [$type] as $named) {
            if (!$named instanceof ReflectionNamedType) {
                continue;
            }

            $name = $named->getName();
            $sample = match (true) {
                'int' === $name => 1,
                'float' === $name => 1.5,
                'string' === $name => 'x',
                'bool' === $name => true,
                'array' === $name => [],
                DateTimeInterface::class === $name => new DateTimeImmutable(),
                DateTimeImmutable::class === $name => new DateTimeImmutable(),
                DateTime::class === $name => new DateTime(),
                default => null,
            };
            if (null !== $sample) {
                $samples[$name] = $sample;
            }
            if (DateTimeInterface::class === $name) {
                $samples[DateTime::class] = new DateTime();
            }
        }

        return $samples;
    }
}

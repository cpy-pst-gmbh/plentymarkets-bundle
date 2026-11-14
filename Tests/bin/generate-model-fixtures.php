<?php

/*
 * Writes the fixtures of the model tests (Tests/ModelDeserializationTest.php):
 *
 * - <Path>.json: an answer as plentymarkets would give it, with every field the model reads
 *   set, nested models and lists included. Nested models go one level deep: each of them has a
 *   fixture of its own, and models that refer to each other would not end. The values are made
 *   up and distinct, so that two fields mixed up show.
 * - <Path>.expected.json: the object the serializer reads from it, every property exported.
 *
 * The fields come from the models as the bundle's serializer sees them: the properties, their
 * types (declaration and @var), #[SerializedName], #[Ignore] and a date format in #[Context].
 * Only a model without a fixture gets one, unless --all is given; --expected writes only the
 * expected states anew, from the fixtures as they are. --to=<dir> writes elsewhere, to compare.
 *
 * The expected states are the golden master: written once, then reviewed in the diff and
 * committed. A change to the serializer or the models has to leave them as they are, or the
 * diff says what changed. (The ones there were recorded with JMS, before #58.)
 *
 *     php Tests/bin/generate-model-fixtures.php [--all|--expected] [--to=<dir>]
 */

use PM\PlentyMarketsBundle\Component\Serializer\SerializerFactory;
use PM\PlentyMarketsBundle\Tests\Support\ModelClasses;
use PM\PlentyMarketsBundle\Tests\Support\ObjectExport;
use PM\PlentyMarketsBundle\Tests\Support\Serializers;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\TypeInfo\Type;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\Type\CollectionType;
use Symfony\Component\TypeInfo\Type\NullableType;
use Symfony\Component\TypeInfo\Type\ObjectType;
use Symfony\Component\TypeInfo\TypeIdentifier;

require dirname(__DIR__, 2).'/vendor/autoload.php';

// As in phpunit.xml.dist: a date without zone is read in the default one.
date_default_timezone_set('UTC');

$mode = '';
$target = ModelClasses::FIXTURES;
foreach (array_slice($argv, 1) as $argument) {
    if (str_starts_with($argument, '--to=')) {
        $target = substr($argument, 5);
    } else {
        $mode = $argument;
    }
}

// The types as the serializer reads them.
$types = SerializerFactory::types();
$serializer = Serializers::bundle();
$written = 0;

/** @return list<ReflectionProperty> the properties the serializer writes, parents' first, in the order declared */
$properties = static function (string $class): array {
    $chain = [];
    for ($reflection = new ReflectionClass($class); false !== $reflection; $reflection = $reflection->getParentClass()) {
        array_unshift($chain, $reflection);
    }

    $properties = [];
    foreach ($chain as $reflection) {
        foreach ($reflection->getProperties() as $property) {
            if ($property->getDeclaringClass()->getName() === $reflection->getName() && !$property->isStatic() && [] === $property->getAttributes(Ignore::class)) {
                $properties[] = $property;
            }
        }
    }

    return $properties;
};

/** A value for a type, distinct from every other in the fixture. */
$value = function (Type $type, int $depth, ?string $format = null) use (&$value, &$sample): mixed {
    static $counter = 0;
    $counter++;

    if ($type instanceof NullableType) {
        $type = $type->getWrappedType();
    }

    if ($type instanceof CollectionType) {
        $item = $type->getCollectionValueType();
        if ($item instanceof BuiltinType && $item->isIdentifiedBy(TypeIdentifier::MIXED)) {
            return ['key-'.$counter => 'value-'.$counter];
        }
        if ($type->isList()) {
            return array_values(array_filter([$value($item, $depth), $value($item, $depth)], static fn ($entry) => null !== $entry));
        }

        return ['key-'.$counter => $value($item, $depth)];
    }

    if ($type instanceof ObjectType) {
        $class = $type->getClassName();
        if (is_a($class, DateTimeInterface::class, true)) {
            // In the format of #[Context], ISO 8601 without one.
            return (new DateTimeImmutable(sprintf('2026-03-%02dT10:%02d:00+01:00', 1 + $counter % 28, $counter % 60)))->format($format ?? DATE_ATOM);
        }

        return $sample($class, $depth + 1);
    }

    if ($type instanceof BuiltinType) {
        return match ($type->getTypeIdentifier()) {
            TypeIdentifier::INT => 1000 + $counter,
            TypeIdentifier::FLOAT => 1000 + $counter + 0.25,
            TypeIdentifier::BOOL => 0 === $counter % 2,
            TypeIdentifier::STRING => 'value-'.$counter,
            TypeIdentifier::ARRAY => ['key-'.$counter => 'value-'.$counter],
            default => throw new RuntimeException('No value for type '.$type),
        };
    }

    throw new RuntimeException('No value for type '.$type);
};

/** @return array<string, mixed>|null every field of the class; null below the first level */
$sample = function (string $class, int $depth = 0) use ($properties, $types, $value): ?array {
    if ($depth > 1) {
        return null;
    }

    $data = [];
    foreach ($properties($class) as $property) {
        $type = $types->getType($class, $property->getName());
        if (null === $type) {
            continue;
        }
        $name = ($property->getAttributes(SerializedName::class)[0] ?? null)?->newInstance()->serializedName ?? $property->getName();
        $format = ($property->getAttributes(Context::class)[0] ?? null)?->newInstance()->denormalizationContext[DateTimeNormalizer::FORMAT_KEY] ?? null;
        $item = $value($type, $depth, $format);
        if (null !== $item) {
            $data[$name] = $item;
        }
    }

    return $data;
};

$flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR;

foreach (ModelClasses::all() as $path => $class) {
    $input = $target.'/'.$path.'.json';
    $expected = $target.'/'.$path.'.expected.json';

    if ('--expected' !== $mode && ('--all' === $mode || !is_file($input))) {
        @mkdir(dirname($input), 0777, true);
        file_put_contents($input, json_encode($sample($class) ?: new stdClass(), $flags)."\n");
    }

    if ('--expected' === $mode || !is_file($expected) || '--all' === $mode) {
        file_put_contents($expected, ObjectExport::toJson($serializer->deserialize((string) file_get_contents($input), $class, 'json')));
        $written++;
    }
}

echo $written, " expected states written\n";

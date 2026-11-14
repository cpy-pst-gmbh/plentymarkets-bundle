<?php

namespace PM\PlentyMarketsBundle\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Tests\Support\ModelClasses;
use PM\PlentyMarketsBundle\Tests\Support\Serializers;
use ReflectionProperty;

use function method_exists;
use function str_starts_with;

/**
 * Every page of plentymarkets read without entries has none, not null (#62): a caller can
 * always merge and loop over getEntries().
 */
final class ResponseEntriesTest extends TestCase
{
    /** @return iterable<string, array{class-string}> */
    public static function responses(): iterable
    {
        foreach (ModelClasses::all() as $path => $class) {
            if (str_starts_with($path, 'Response/') && method_exists($class, 'getEntries')) {
                yield $path => [$class];
            }
        }
    }

    #[DataProvider('responses')]
    public function testAPageWithoutEntriesHasNone(string $class): void
    {
        self::assertSame('array', (string) (new ReflectionProperty($class, 'entries'))->getType());

        $response = Serializers::bundle()->deserialize('{"page":1,"isLastPage":true}', $class, 'json');

        self::assertSame([], $response->getEntries());
    }
}

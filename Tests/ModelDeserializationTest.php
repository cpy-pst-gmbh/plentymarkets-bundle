<?php

namespace PM\PlentyMarketsBundle\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Tests\Support\ModelClasses;
use PM\PlentyMarketsBundle\Tests\Support\ObjectExport;
use PM\PlentyMarketsBundle\Tests\Support\Serializers;

use function file_get_contents;
use function is_file;

/**
 * Every model, read from an answer that sets each of its fields, ends up exactly as recorded
 * (golden master, see Tests/bin/generate-model-fixtures.php). A change to the serializer or to
 * the mapping of a model shows here as a diff of the whole object.
 */
final class ModelDeserializationTest extends TestCase
{
    /** @return iterable<string, array{string, class-string}> */
    public static function models(): iterable
    {
        foreach (ModelClasses::all() as $path => $class) {
            yield $path => [$path, $class];
        }
    }

    #[DataProvider('models')]
    public function testTheModelIsReadAsRecorded(string $path, string $class): void
    {
        $input = ModelClasses::FIXTURES.'/'.$path.'.json';
        $expected = ModelClasses::FIXTURES.'/'.$path.'.expected.json';
        self::assertFileExists($input, 'A new model needs a fixture: php Tests/bin/generate-model-fixtures.php');
        self::assertFileExists($expected);

        $model = Serializers::bundle()->deserialize((string) file_get_contents($input), $class, 'json');

        self::assertInstanceOf($class, $model);
        self::assertSame((string) file_get_contents($expected), ObjectExport::toJson($model));
    }

    public function testThereIsNoFixtureWithoutModel(): void
    {
        $models = ModelClasses::all();
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(ModelClasses::FIXTURES, \RecursiveDirectoryIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            $path = substr($file->getPathname(), \strlen(ModelClasses::FIXTURES) + 1);
            $path = preg_replace('/(\.expected)?\.json$/', '', $path);
            self::assertArrayHasKey($path, $models, 'The fixture of a model that is gone: '.$file->getPathname());
        }

        self::assertTrue(is_file(ModelClasses::FIXTURES.'/Model/Order/Order.json'), 'The fixtures were found at all.');
    }
}

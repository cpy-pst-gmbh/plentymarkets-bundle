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
 * The fields come from the JMS metadata of the models. Only a model without a fixture gets
 * one, unless --all is given; --expected writes only the expected states anew, from the
 * fixtures as they are.
 *
 * The expected states are the golden master: written once, then reviewed in the diff and
 * committed. A change to the serializer or the models has to leave them as they are, or the
 * diff says what changed.
 *
 *     php Tests/bin/generate-model-fixtures.php [--all|--expected]
 */

use JMS\Serializer\Metadata\Driver\AnnotationOrAttributeDriver;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use Metadata\MetadataFactory;
use PM\PlentyMarketsBundle\Tests\Support\ModelClasses;
use PM\PlentyMarketsBundle\Tests\Support\ObjectExport;
use PM\PlentyMarketsBundle\Tests\Support\Serializers;

require dirname(__DIR__, 2).'/vendor/autoload.php';

// As in phpunit.xml.dist: a date without zone is read in the default one.
date_default_timezone_set('UTC');

$mode = $argv[1] ?? '';
$metadata = new MetadataFactory(new AnnotationOrAttributeDriver(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy())));
$serializer = Serializers::bundle();
$written = 0;

/** A value for a JMS type, distinct from every other in the fixture. */
$value = function (array $type, int $depth) use (&$value, &$sample): mixed {
    static $counter = 0;
    $counter++;

    return match (strtolower($type['name'])) {
        'integer', 'int' => 1000 + $counter,
        'float', 'double' => 1000 + $counter + 0.25,
        'boolean', 'bool' => 0 === $counter % 2,
        'string' => 'value-'.$counter,
        // In the format the type names, ISO 8601 (JMS' default) without one.
        'datetime', 'datetimeimmutable', 'datetimeinterface' => (new DateTimeImmutable(sprintf('2026-03-%02dT10:%02d:00+01:00', 1 + $counter % 28, $counter % 60)))
            ->format($type['params'][0] ?? DATE_ATOM),
        'array' => match (count($type['params'])) {
            0 => ['key-'.$counter => 'value-'.$counter],
            1 => array_values(array_filter([$value($type['params'][0], $depth), $value($type['params'][0], $depth)], static fn ($item) => null !== $item)),
            default => ['key-'.$counter => $value($type['params'][1], $depth)],
        },
        default => class_exists($type['name']) ? $sample($type['name'], $depth + 1) : throw new RuntimeException('Unknown type '.$type['name']),
    };
};

/** @return array<string, mixed>|null every field of the class; null below the first level */
$sample = function (string $class, int $depth = 0) use ($metadata, $value): ?array {
    if ($depth > 1) {
        return null;
    }

    $data = [];
    foreach ($metadata->getMetadataForClass($class)->propertyMetadata as $property) {
        if (null === $property->type) {
            continue;
        }
        $item = $value($property->type, $depth);
        if (null !== $item) {
            $data[$property->serializedName] = $item;
        }
    }

    return $data;
};

$flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR;

foreach (ModelClasses::all() as $path => $class) {
    $input = ModelClasses::FIXTURES.'/'.$path.'.json';
    $expected = ModelClasses::FIXTURES.'/'.$path.'.expected.json';

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

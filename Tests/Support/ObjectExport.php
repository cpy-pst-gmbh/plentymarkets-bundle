<?php

namespace PM\PlentyMarketsBundle\Tests\Support;

use DateTimeInterface;
use ReflectionClass;
use ReflectionProperty;

use function array_keys;
use function get_object_vars;
use function is_array;
use function is_object;
use function json_encode;
use function ksort;

use const JSON_PRESERVE_ZERO_FRACTION;
use const JSON_PRETTY_PRINT;
use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;

/**
 * The whole state of an object graph as plain data: every property of every class in the
 * hierarchy, private ones included, read by reflection and not through getters, so that a value
 * a getter would hide or convert still shows. Dates keep their class and zone; integers and
 * floats stay apart.
 */
final class ObjectExport
{
    public static function toJson(mixed $value): string
    {
        return json_encode(self::export($value), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR)."\n";
    }

    public static function export(mixed $value): mixed
    {
        if ($value instanceof DateTimeInterface) {
            return ['@class' => $value::class, '@value' => $value->format('Y-m-d\TH:i:s.uP e')];
        }

        if (is_object($value)) {
            $result = ['@class' => $value::class];
            $properties = [];
            for ($class = new ReflectionClass($value); false !== $class; $class = $class->getParentClass()) {
                foreach ($class->getProperties() as $property) {
                    if ($property->isStatic() || isset($properties[$property->getName()])) {
                        continue;
                    }
                    $properties[$property->getName()] = $property->isInitialized($value)
                        ? self::export($property->getValue($value))
                        : '@uninitialized';
                }
            }
            // Properties set without a declaration, which only reflection of the object sees.
            foreach (array_keys(get_object_vars($value)) as $name) {
                $properties[$name] ??= self::export((new ReflectionProperty($value, $name))->getValue($value));
            }
            ksort($properties);

            return $result + $properties;
        }

        if (is_array($value)) {
            $result = [];
            foreach ($value as $key => $item) {
                $result[$key] = self::export($item);
            }

            return $result;
        }

        return $value;
    }
}

<?php

namespace PM\PlentyMarketsBundle\Component\Serializer;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use TypeError;

/**
 * Reads the answers of plentymarkets into the models as JMS did before (#58), and writes the
 * batch requests: by reflection on the properties, private ones included, past the setters and
 * getters. Like Symfony's PropertyNormalizer, which is final, with one difference: a null for a
 * property that cannot hold one is left out, as if the field were missing, instead of failing
 * the whole answer.
 */
final class ModelNormalizer extends AbstractObjectNormalizer
{
    public function getSupportedTypes(?string $format): array
    {
        return ['object' => true];
    }

    protected function isAllowedAttribute(object|string $classOrObject, string $attribute, ?string $format = null, array $context = []): bool
    {
        if (!parent::isAllowedAttribute($classOrObject, $attribute, $format, $context)) {
            return false;
        }

        $property = self::property($classOrObject, $attribute);

        return null !== $property && !$property->isStatic();
    }

    protected function extractAttributes(object $object, ?string $format = null, array $context = []): array
    {
        $attributes = [];
        for ($class = new ReflectionClass($object); false !== $class; $class = $class->getParentClass()) {
            foreach ($class->getProperties() as $property) {
                $name = $property->getName();
                if (!$property->isStatic() && !isset($attributes[$name]) && $this->isAllowedAttribute($object, $name, $format, $context)) {
                    $attributes[$name] = $name;
                }
            }
        }

        return array_values($attributes);
    }

    protected function getAttributeValue(object $object, string $attribute, ?string $format = null, array $context = []): mixed
    {
        $property = self::property($object, $attribute);
        if (null === $property || !$property->isInitialized($object)) {
            return null;
        }

        return $property->getValue($object);
    }

    protected function setAttributeValue(object $object, string $attribute, mixed $value, ?string $format = null, array $context = []): void
    {
        $property = self::property($object, $attribute);
        if (null === $property || $property->isStatic()) {
            return;
        }

        if (null === $value && $property->hasType() && false === $property->getType()?->allowsNull()) {
            return;
        }

        if ($property->isReadOnly() && $property->isInitialized($object)) {
            if ($property->getValue($object) !== $value) {
                throw new LogicException(sprintf('Attempting to change readonly property "%s"::$%s.', $object::class, $attribute));
            }

            return;
        }

        // plentymarkets may send decimals where the model declares an int.
        // PHP would cut them off as well, but with a notice that Symfony's ErrorHandler turns
        // into an exception for the whole answer. JMS cut them off silently, and so do we.
        if (is_float($value) && is_finite($value) && self::takesIntButNotFloat($property)) {
            $value = (int) $value;
        }

        try {
            $property->setValue($object, $value);
        } catch (TypeError $exception) {
            throw NotNormalizableValueException::createForUnexpectedDataType(sprintf('Failed to denormalize attribute "%s" value for class "%s": %s', $attribute, $object::class, $exception->getMessage()), $value, ['unknown'], $context['deserialization_path'] ?? null, false, $exception->getCode(), $exception);
        }
    }

    private static function takesIntButNotFloat(ReflectionProperty $property): bool
    {
        $type = $property->getType();
        $names = match (true) {
            $type instanceof ReflectionNamedType => [$type->getName()],
            $type instanceof ReflectionUnionType => array_map(static fn (ReflectionType $t): string => $t instanceof ReflectionNamedType ? $t->getName() : '', $type->getTypes()),
            default => [],
        };

        return in_array('int', $names, true) && !in_array('float', $names, true);
    }

    /** The property of that name, declared by the class or one of its parents. */
    private static function property(object|string $classOrObject, string $name): ?ReflectionProperty
    {
        for ($class = new ReflectionClass($classOrObject); false !== $class; $class = $class->getParentClass()) {
            if ($class->hasProperty($name)) {
                return $class->getProperty($name);
            }
        }

        return null;
    }
}

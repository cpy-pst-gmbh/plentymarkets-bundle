<?php

namespace PM\PlentyMarketsBundle\Component\Serializer;

use ReflectionClass;
use ReflectionProperty;
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

        try {
            $property->setValue($object, $value);
        } catch (TypeError $exception) {
            throw NotNormalizableValueException::createForUnexpectedDataType(sprintf('Failed to denormalize attribute "%s" value for class "%s": %s', $attribute, $object::class, $exception->getMessage()), $value, ['unknown'], $context['deserialization_path'] ?? null, false, $exception->getCode(), $exception);
        }
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

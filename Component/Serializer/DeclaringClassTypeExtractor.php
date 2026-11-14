<?php

namespace PM\PlentyMarketsBundle\Component\Serializer;

use ReflectionClass;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\TypeInfo\Type;

/**
 * The type of a property asked for at the class that declares it. PropertyInfo does not see a
 * private property of a parent class from the child (OrderAmount::$currency is BaseAmount's),
 * and without a type the serializer would leave a date or a model there as raw data.
 */
final readonly class DeclaringClassTypeExtractor implements PropertyTypeExtractorInterface
{
    public function __construct(
        private PropertyTypeExtractorInterface $extractor,
    ) {
    }

    public function getType(string $class, string $property, array $context = []): ?Type
    {
        for ($reflection = new ReflectionClass($class); false !== $reflection; $reflection = $reflection->getParentClass()) {
            if ($reflection->hasProperty($property)) {
                return $this->extractor->getType($reflection->getProperty($property)->getDeclaringClass()->getName(), $property, $context);
            }
        }

        return $this->extractor->getType($class, $property, $context);
    }
}

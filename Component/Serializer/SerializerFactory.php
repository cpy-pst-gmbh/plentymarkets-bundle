<?php

namespace PM\PlentyMarketsBundle\Component\Serializer;

use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * The serializer the bundle reads plentymarkets with (Symfony, since #58 in place of JMS). The
 * bundle builds it itself, so that it does not depend on how the application configures its
 * own serializer:
 *
 * - The types come from the properties of the models alone, their declaration and their @var,
 *   not from setters and getters, whose docblocks are not kept up to date.
 * - The names are those of the properties, or of #[SerializedName].
 * - Values are not checked against the types but assigned, as JMS did; PHP converts "5" to 5
 *   or 3 to 3.0 on the way into a typed property.
 */
final class SerializerFactory
{
    public static function create(): SerializerInterface
    {
        $metadata = new ClassMetadataFactory(new AttributeLoader());

        $models = new ModelNormalizer($metadata, new MetadataAwareNameConverter($metadata), self::types(), defaultContext: [
            AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
        ]);

        return new Serializer([new DateTimeNormalizer(), new ArrayDenormalizer(), $models], [new JsonEncoder()]);
    }

    /** The types of the models' properties: declaration and @var, at the class that declares them. */
    public static function types(): PropertyTypeExtractorInterface
    {
        return new DeclaringClassTypeExtractor(new PropertyInfoExtractor(
            typeExtractors: [
                new PhpStanExtractor([], [], []),
                new ReflectionExtractor([], [], [], false, ReflectionExtractor::ALLOW_PUBLIC | ReflectionExtractor::ALLOW_PROTECTED | ReflectionExtractor::ALLOW_PRIVATE),
            ],
        ));
    }
}

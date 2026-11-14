<?php

namespace PM\PlentyMarketsBundle\Tests\Support;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

/**
 * The serializer as the bundle registers it (Resources/config/services_orm.yml): JMS with the
 * names as they are, or as #[JMS\SerializedName] gives them. The one place the tests name the
 * serializer, so that a switch (#58) changes it here and the fixtures stay as they are.
 */
final class Serializers
{
    public static function bundle(): SerializerInterface
    {
        return SerializerBuilder::create()
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
            ->build();
    }
}

<?php

namespace PM\PlentyMarketsBundle\Tests\Support;

use PM\PlentyMarketsBundle\Component\Serializer\SerializerFactory;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * The serializer as the bundle builds it (SerializerFactory, Symfony since #58). The one place
 * the tests name it; the fixtures of the model tests were recorded with JMS before the switch
 * and have to come out the same.
 */
final class Serializers
{
    public static function bundle(): SerializerInterface
    {
        return SerializerFactory::create();
    }
}

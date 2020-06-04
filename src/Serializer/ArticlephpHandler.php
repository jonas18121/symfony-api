<?php

namespace App\Serializer;

use App\Entity\Article;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\SerializationContext as Context;
use JMS\Serializer\Handler\SubscribingHandlerInterface;

class ArticlephpHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format'    => 'json',
                'type'      => 'App\Entity\Article',
                'method'    => 'serialize',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format'    => 'json',
                'type'      => 'App\Entity\Article',
                'method'    => 'deserialize',  
            ]
        ];
    }
    public function serialize(JsonSerializationVisitor $visitor, Article $article, array $type, Context $context)
    {

    }

    public function deserialize(JsonDeserializationVisitor $visitor, $data)
    {

    }
}
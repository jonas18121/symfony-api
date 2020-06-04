<?php

namespace App\Serializer\Listener;

use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventDispatcherInterface;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Metadata\StaticPropertyMetadata;

class ArticleListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            [
                'event'     => Events::POST_SERIALIZE,  //avant serialisation
                'format'    => 'json',                  // format
                'class'     => 'App\Entity\Article',    // Class utiliser
                'method'    => 'onPostSerialize',       // nom de la methode utiliser
            ]
        ];
    }

    public static function onPostSerialize(ObjectEvent $event)
    {
        //possibilté de récupérer l'objet qui a été sérialisé
        $object = $event->getObject();

        $date = new \DateTime();

        //possibilté de modifier le tableau après sérialisation
        $event->getVisitor()->visitProperty(new StaticPropertyMetadata('', 'delivered_at', null), $date->format('l js \of F Y h:i:s A'));
    }
}
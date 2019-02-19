<?php

namespace App\Domain\Event;


class EventPublisher
{
    public static function publish(DomainEvent $domainEvent)
    {
        // TODO: this event publisher would insert into a RabbitMQ queue a new message
    }
}
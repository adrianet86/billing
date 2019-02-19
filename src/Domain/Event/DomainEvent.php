<?php


namespace App\Domain\Event;


interface DomainEvent
{
    public function occurredOn(): \DateTimeImmutable;
}
<?php

namespace App\Domain\Billing;

use App\Domain\Event\DomainEvent;

/**
 * EVENT BillingPaid
 * @package App\Domain\Billing
 *
 */
class BillingPaid implements DomainEvent
{
    private $billingId;
    private $occurredOn;

    public function __construct(string $billingId)
    {
        $this->billingId = $billingId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function billingId(): string
    {
        return $this->billingId;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
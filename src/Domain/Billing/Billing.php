<?php

namespace App\Domain\Billing;


use App\Domain\Event\EventPublisher;
use App\Domain\Payment\PaymentDetails;

class Billing
{
    /* @var string */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function isBlocked(): bool
    {

    }

    public function isPaid(): bool
    {

    }

    /**
     * @throws BillingBlockedException
     * @throws BillingPaidException
     */
    public function block(): void
    {
        if ($this->isPaid()) {
            throw new BillingPaidException('BILLING ALREADY PAID');
        }

        if ($this->isBlocked()) {
            throw new BillingBlockedException('BILLING IS BLOCKED');
        }

        // Block billing
    }

    public function unblock(): void
    {

    }

    public function setPaymentDetails(PaymentDetails $paymentDetails)
    {
        // Set paymentDetails, unblock and set paid

        EventPublisher::publish(new BillingPaid($this->id));
    }
}
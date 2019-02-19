<?php

namespace App\Application\Payment;


class PaymentRequest
{
    private $billingId;
    private $paymentDetails;
    private $policyDetails;

    public function __construct(string $billingId, array $paymentDetails, array $policyDetails)
    {
        $this->billingId = $billingId;
        $this->paymentDetails = $paymentDetails;
        $this->policyDetails = $policyDetails;
    }

    public function billingId(): string
    {
        return $this->billingId;
    }

    public function paymentDetails(): array
    {
        return $this->paymentDetails;
    }

    public function policyDetails(): array
    {
        return $this->policyDetails;
    }
}
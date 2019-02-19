<?php

namespace App\Domain\Payment;


use App\Domain\Billing\Billing;

interface PaymentMethod
{
    /**
     * @param Billing $billing
     * @param $requestDetails
     * @return PaymentDetails
     * @throws PaymentDeclinedException
     *
     */
    public function payBilling(Billing $billing, $requestDetails): PaymentDetails;
}
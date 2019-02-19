<?php

namespace App\Infrastructure\External\Payment;


use App\Domain\Billing\Billing;
use App\Domain\Payment\PaymentDeclinedException;
use App\Domain\Payment\PaymentDetails;
use App\Domain\Payment\PaymentMethod;

class CreditCardPaymentMethod implements PaymentMethod
{

    /**
     * @param Billing $billing
     * @param $requestDetails
     * @return PaymentDetails
     * @throws PaymentDeclinedException
     *
     */
    public function payBilling(Billing $billing, $requestDetails): PaymentDetails
    {
        return new PaymentDetails();
    }
}
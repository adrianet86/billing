<?php


namespace App\Domain\Billing;


interface BillingRepository
{
    /**
     * @param string $id
     * @return Billing
     * @throws BillingNotFoundException
     *
     */
    public function byId(string $id): Billing;
}
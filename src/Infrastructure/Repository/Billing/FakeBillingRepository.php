<?php

namespace App\Infrastructure\Repository\Billing;


use App\Domain\Billing\Billing;
use App\Domain\Billing\BillingNotFoundException;
use App\Domain\Billing\BillingRepository;

class FakeBillingRepository implements BillingRepository
{
    /**
     * @param string $id
     * @return Billing
     * @throws BillingNotFoundException
     */
    public function byId(string $id): Billing
    {
        return new Billing($id);
    }
}
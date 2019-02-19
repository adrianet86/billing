<?php

namespace App\Domain\Policy;


class FraudPolicy implements Policy
{
    /**
     * @param $request
     * @return mixed
     * @throws PolicyException
     */
    public function execute($request)
    {

    }
}
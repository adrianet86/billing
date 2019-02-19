<?php


namespace App\Domain\Policy;


interface Policy
{
    /**
     * @param $request
     * @return mixed
     * @throws PolicyException
     */
    public function execute($request);
}
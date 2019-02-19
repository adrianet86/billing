<?php


namespace App\Domain\Policy;


interface Policy
{
    /**
     * @param $request
     * @return mixed
     */
    public function execute($request);
}
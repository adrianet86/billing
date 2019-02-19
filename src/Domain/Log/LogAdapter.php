<?php

namespace App\Domain\Log;


interface LogAdapter
{
    /**
     * @param string $message
     * @throws LogAdapterException
     */
    public function log(string $message): void;
}
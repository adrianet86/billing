<?php

namespace App\Infrastructure\External\Log;


use App\Domain\Log\LogAdapter;
use App\Domain\Log\LogAdapterException;

class AwsLogAdapter implements LogAdapter
{
    /**
     * @param string $message
     * @throws LogAdapterException
     */
    public function log(string $message): void
    {
        // TODO: Implement to write in Amazon Web Service CloudWatch Logs.
    }
}
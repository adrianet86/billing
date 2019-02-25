<?php

namespace App\Infrastructure\Repository\Log;


use App\Domain\Log\LogAdapter;
use App\Domain\Log\LogAdapterException;

class FakeLogAdapterRepository implements LogAdapter
{
    /**
     * @param string $message
     * @throws LogAdapterException
     */
    public function log(string $message): void
    {
        // TODO
    }
}

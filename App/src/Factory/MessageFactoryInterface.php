<?php

declare(strict_types=1);

namespace App\Factory;

interface MessageFactoryInterface
{
    public function createMessage(array $data): object;
}

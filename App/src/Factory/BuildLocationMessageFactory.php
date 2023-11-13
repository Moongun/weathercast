<?php

declare(strict_types=1);

namespace App\Factory;

use App\Message\Command\BuildLocation;

class BuildLocationMessageFactory implements MessageFactoryInterface
{
    public function createMessage(array $data): object
    {
        return new BuildLocation(city: $data['city'], country: $data['country']);
    }
}

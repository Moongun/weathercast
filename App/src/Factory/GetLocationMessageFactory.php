<?php

declare(strict_types=1);

namespace App\Factory;

use App\Message\Query\GetLocation;

class GetLocationMessageFactory implements MessageFactoryInterface
{
    public function createMessage(array $data): object
    {
        return new GetLocation(city: $data['city'], country: $data['country']);
    }
}

<?php

declare(strict_types=1);

namespace App\Factory;

use App\Message\Command\CreateLocation;
use App\Service\Geocoding\GeocodingServiceInterface;

class CreateLocationMessageFactory implements MessageFactoryInterface
{
    public function __construct(
        private GeocodingServiceInterface $geocodingService,
    ) {
    }

    public function createMessage(array $data): object
    {
        $city = $data['city'];
        $country = $data['country'];

        return new CreateLocation(
            city: $city,
            country: $country,
            point: $this->geocodingService->getPoint($city, $country)
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Service\Geocoding;

use App\Entity\DTO\Point;

interface GeocodingServiceInterface
{
    public function getPoint(string $city, string $country): Point;
}

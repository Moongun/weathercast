<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Entity\DTO\Point;

final class CreateLocation
{
    public function __construct(
        private string $city,
        private string $country,
        private Point $point,
    ) {
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPoint(): Point
    {
        return $this->point;
    }
}

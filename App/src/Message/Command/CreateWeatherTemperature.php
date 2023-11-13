<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Entity\Location;

final class CreateWeatherTemperature
{
    public function __construct(
        private Location $location,
        private float $temperature,
    ) {
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }
}

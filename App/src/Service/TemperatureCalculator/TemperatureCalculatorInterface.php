<?php

declare(strict_types=1);

namespace App\Service\TemperatureCalculator;

use App\Entity\Location;

interface TemperatureCalculatorInterface
{
    public function calculateTemperature(Location $location): ?float;
}

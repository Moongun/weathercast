<?php

declare(strict_types=1);

namespace App\Service\TemperatureCalculator;

use App\Entity\Location;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::class)]
interface TemperatureCollectorInterface
{
    public function collect(Location $location): float;
}

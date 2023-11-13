<?php

declare(strict_types=1);

namespace App\Message\Command;

final class BuildLocation
{
    public function __construct(
        private string $city,
        private string $country,
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
}

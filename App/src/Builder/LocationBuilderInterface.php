<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Location;

interface LocationBuilderInterface
{
    public function build(string $city, string $country): Location;
}

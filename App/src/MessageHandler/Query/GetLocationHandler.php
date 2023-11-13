<?php

declare(strict_types=1);

namespace App\MessageHandler\Query;

use App\Entity\Location;
use App\Message\Query\GetLocation;
use App\Repository\LocationRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetLocationHandler
{
    public function __construct(
        private LocationRepository $locationRepository
    ) {
    }

    public function __invoke(GetLocation $message): ?Location
    {
        $location = $this->locationRepository->findOneBy(['country' => $message->getCountry(), 'city' => $message->getCity()]);

        return $location;
    }
}

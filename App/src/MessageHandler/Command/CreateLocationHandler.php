<?php

declare(strict_types=1);

namespace App\MessageHandler\Command;

use App\Entity\Location;
use App\Message\Command\CreateLocation;
use App\Repository\LocationRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateLocationHandler
{
    public function __construct(
        private LocationRepository $locationRepository
    ) {
    }

    public function __invoke(CreateLocation $message): void
    {
        $this->locationRepository->save(
            (new Location())
            ->setCountry($message->getCountry())
            ->setCity($message->getCity())
            ->setPoint($message->getPoint())
        );
    }
}

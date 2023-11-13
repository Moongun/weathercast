<?php

declare(strict_types=1);

namespace App\MessageHandler\Command;

use App\Builder\LocationBuilderInterface;
use App\Cache\CacheAdapterInterface;
use App\Entity\Location;
use App\Message\Command\BuildLocation;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\ItemInterface;

#[AsMessageHandler]
final class BuildLocationHandler
{
    public function __construct(
        private LocationBuilderInterface $locationBuilder,
        private CacheAdapterInterface $cache,
    ) {
    }

    public function __invoke(BuildLocation $message): Location
    {
        $key = $message->getCountry() . '_' . $message->getCity();

        return $this->cache->get(
            $key,
            fn (ItemInterface $item) => $this->locationBuilder->build(city: $message->getCity(), country: $message->getCountry())
        );
    }
}

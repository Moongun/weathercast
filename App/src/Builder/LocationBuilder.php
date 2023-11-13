<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Location;
use App\Factory\CreateLocationMessageFactory;
use App\Factory\CreateWeatherMessageFactory;
use App\Factory\GetLocationMessageFactory;
use App\Factory\MessageFactoryInterface;
use DateTimeImmutable;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class LocationBuilder implements LocationBuilderInterface
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        #[Autowire(service: CreateLocationMessageFactory::class)]
        private MessageFactoryInterface $createLocationMessageFactory,
        #[Autowire(service: CreateWeatherMessageFactory::class)]
        private MessageFactoryInterface $createWeatherMessageFactory,
        #[Autowire(service: GetLocationMessageFactory::class)]
        private MessageFactoryInterface $getLocationMessageFactory,
    ) {
    }

    public function build(string $city, string $country): Location
    {
        $data = ['city' => $city, 'country' => $country];

        /** @var Location $location */
        $location = $this->refreshLocation($data) ?? $this->createLocation($data);

        $weather = $location->getWeather();
        if (null === $weather || $weather->getUpdatedAt() < new DateTimeImmutable('-1 hour')) {
            $location = $this->updateLocationWeather($data);
        }

        return $location;
    }

    private function updateLocationWeather(array $data): Location
    {
        $this->handle($this->createWeatherMessageFactory->createMessage($data));

        return $this->refreshLocation($data);
    }

    private function createLocation(array $data): Location
    {
        $this->handle($this->createLocationMessageFactory->createMessage($data));
        $this->updateLocationWeather($data);

        return $this->refreshLocation($data);
    }

    private function refreshLocation(array $data): ?Location
    {
        return $this->handle($this->getLocationMessageFactory->createMessage($data));
    }
}

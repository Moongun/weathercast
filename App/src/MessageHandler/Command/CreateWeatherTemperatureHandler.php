<?php

declare(strict_types=1);

namespace App\MessageHandler\Command;

use App\Entity\Weather;
use App\Message\Command\CreateWeatherTemperature;
use App\Repository\WeatherRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateWeatherTemperatureHandler
{
    public function __construct(
        private WeatherRepository $weatherRepository,
    ) {
    }

    public function __invoke(CreateWeatherTemperature $message): void
    {
        $weather = $message->getLocation()?->getWeather();

        $this->weatherRepository->save(
            ($weather ?? (new Weather()))
                ->setLocation($message->getLocation())
                ->setTemperature($message->getTemperature())
                ->setUpdatedAt()
        );
    }
}

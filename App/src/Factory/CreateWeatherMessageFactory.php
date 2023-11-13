<?php

declare(strict_types=1);

namespace App\Factory;

use App\Message\Command\CreateWeatherTemperature;
use App\Service\TemperatureCalculator\TemperatureCalculatorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateWeatherMessageFactory implements MessageFactoryInterface
{
    use HandleTrait;

    public function __construct(
        #[Autowire(service: GetLocationMessageFactory::class)]
        private MessageFactoryInterface $messageFactory,
        private TemperatureCalculatorInterface $temperatureCalculator,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function createMessage(array $data): object
    {
        $location = $this->handle($this->messageFactory->createMessage($data));

        return new CreateWeatherTemperature(
            location: $location,
            temperature: $this->temperatureCalculator->calculateTemperature($location)
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Service\TemperatureCalculator;

use App\Entity\Location;
use App\Exceptions\RequestException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class AverageTemperatureCalculator implements TemperatureCalculatorInterface
{
    public function __construct(
        #[TaggedIterator(TemperatureCollectorInterface::class)]
        private iterable $temperatureCollectors,
        private LoggerInterface $logger,
    ) {
    }

    public function calculateTemperature(Location $location): ?float
    {
        $temperatures = $this->collectData($location);
        $summedTemperature = $this->sumUp($temperatures);
        $count = count($temperatures);

        return 0 !== $count ? round($summedTemperature / $count, 3) : null;
    }

    private function collectData(Location $location): array
    {
        $temperatures = [];

        /** @var TemperatureCollectorInterface $temperatureCollector */
        foreach ($this->temperatureCollectors as $temperatureCollector) {
            try {
                $temperatures[] = $temperatureCollector->collect($location);
            } catch (RequestException $exception) {
                $this->logger->error($exception->getMessage());
            }
        }

        return $temperatures;
    }

    public function sumUp(array $temperatures): ?float
    {
        return array_reduce(
            $temperatures,
            static fn(?float $sum, float $temperature): float => $sum + $temperature
        );
    }
}

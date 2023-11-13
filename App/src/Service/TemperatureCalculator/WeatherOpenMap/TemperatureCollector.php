<?php

declare(strict_types=1);

namespace App\Service\TemperatureCalculator\WeatherOpenMap;

use App\Entity\DTO\Point;
use App\Entity\Location;
use App\Exceptions\RequestException;
use App\Service\RequestInterface;
use App\Service\TemperatureCalculator\TemperatureCollectorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TemperatureCollector implements TemperatureCollectorInterface
{
    public function __construct(
        #[Autowire(service: TemperatureRequest::class)]
        private RequestInterface $request,
    ) {
    }

    public function collect(Location $location): float
    {
        $response = $this->request->call($this->prepareInputData($location->getPoint()));

        $content = json_decode($response->getContent(), true);

        if (!isset($content['main']['temp'])) {
            throw new RequestException(static::class . ": Content unknown");
        }

        return (float) $content['main']['temp'];
    }

    private function prepareInputData(Point $point): array
    {
        return [
            'query' => [
                'units' => 'metric',
                'lat' => $point->getLatitude(),
                'lon' => $point->getLongitude()
            ]
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Service\TemperatureCalculator\MeteoMatics;

use App\Entity\DTO\Point;
use App\Entity\Location;
use App\Exceptions\RequestException;
use App\Service\RequestInterface;
use App\Service\TemperatureCalculator\TemperatureCollectorInterface;
use DateTime;
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

        if (!isset($content['data'][0]['coordinates'][0]['dates'][0]['value'])) {
            throw new RequestException(static::class . ": Content unknown");
        }

        return (float) $content['data'][0]['coordinates'][0]['dates'][0]['value'];
    }

    private function prepareInputData(Point $point): array
    {
        return [
            'time' => (new DateTime())->format(DATE_ATOM),
            'parameters' => implode(',', ['t_2m:C']),
            'location' => implode(',', [$point->getLatitude(), $point->getLongitude()]),
            'format' => 'json',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Service\Geocoding;

use App\Entity\DTO\Point;
use App\Exceptions\RequestException;
use App\Service\RequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class GeocodingService implements GeocodingServiceInterface
{
    public function __construct(
        #[Autowire(service: GeocodingRequest::class)]
        private RequestInterface $geocodingRequest,
    ) {
    }

    public function getPoint(string $city, string $country): Point
    {
        $response = $this->geocodingRequest->call($this->prepareInputData($city, $country));

        $content = json_decode($response->getContent(), true);

        if (!isset($content[0]['lat']) || !isset($content[0]['lon'])) {
            throw new RequestException(static::class . ": Content unknown");
        }

        return new Point(latitude: $content[0]['lat'], longitude: $content[0]['lon']);
    }

    private function prepareInputData(string $city, string $country): array
    {
        return [
            'query' => [
                'q' => sprintf('%s,%s', $city, $country),
                'limit' => 1,
            ]
        ];
    }
}

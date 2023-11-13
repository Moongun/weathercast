<?php

declare(strict_types=1);

namespace App\Service\Geocoding;

use App\Service\AbstractRequest;
use App\Service\RequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GeocodingRequest extends AbstractRequest implements RequestInterface
{
    private const URL = 'http://api.openweathermap.org/geo/1.0/direct';

    public function __construct(
        private HttpClientInterface $client,
        private string $openWeatherMapApiId,
    ) {
    }

    public function call(array $inputData = []): ResponseInterface
    {
        $authData = ['query' => ['appId' => $this->openWeatherMapApiId]];

        $options = array_merge_recursive($inputData, $authData);

        $response = $this->client->request(Request::METHOD_GET, self::URL, $options);

        $this->isSuccessful($response);

        return $response;
    }
}

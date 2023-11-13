<?php

declare(strict_types=1);

namespace App\Service\TemperatureCalculator\MeteoMatics;

use App\Service\AbstractRequest;
use App\Service\RequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TemperatureRequest extends AbstractRequest implements RequestInterface
{
    private const URL = 'https://api.meteomatics.com/%s/%s/%s/%s';

    public function __construct(
        private HttpClientInterface $client,
        private string $meteoMaticsCredentials,
    ) {
    }

    public function call(array $inputData = []): ResponseInterface
    {
        $authData = ['headers' => ['Authorization' => 'Basic ' . base64_encode($this->meteoMaticsCredentials)]];

        $response = $this->client->request(Request::METHOD_GET, $this->prepareUrl($inputData), $authData);

        $this->isSuccessful($response);

        return $response;
    }

    private function prepareUrl(array $inputData): string
    {
        return sprintf(self::URL, $inputData['time'], $inputData['parameters'], $inputData['location'], $inputData['format']);
    }
}

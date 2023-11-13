<?php

declare(strict_types=1);

namespace App\Tests\unit\Service\TemperatureCalculator\WeatherOpenMap;

use App\Exceptions\RequestException;
use App\Service\TemperatureCalculator\WeatherOpenMap\TemperatureRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TemperatureRequestTest extends TestCase
{
    public function testInvalidApiId(): void
    {
        $responseStub = $this->createStub(ResponseInterface::class);
        $responseStub
            ->method('getStatusCode')
            ->willReturn(Response::HTTP_UNAUTHORIZED);

        $clientStub = $this->createStub(HttpClientInterface::class);
        $clientStub
            ->method('request')
            ->willReturn($responseStub);

        $temperatureRequest = new TemperatureRequest($clientStub, 'invalid-api-id');

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage(sprintf('Call of %s failed with code %s', $temperatureRequest::class, Response::HTTP_UNAUTHORIZED));

        $temperatureRequest->call();
    }
}

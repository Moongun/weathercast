<?php

declare(strict_types=1);

namespace App\Tests\unit\Service\TemperatureCalculator\WeatherOpenMap;

use App\Entity\DTO\Point;
use App\Entity\Location;
use App\Exceptions\RequestException;
use App\Service\RequestInterface;
use App\Service\TemperatureCalculator\WeatherOpenMap\TemperatureCollector;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TemperatureCollectorTest extends TestCase
{
    public function testInvalidContent(): void
    {
        $responseStub = $this->createStub(ResponseInterface::class);
        $responseStub->method('getContent')->willReturn(json_encode([]));

        $requestStub = $this->createStub(RequestInterface::class);
        $requestStub->method('call')->willReturn($responseStub);

        $collector = new TemperatureCollector($requestStub);

        $location = (new Location())
            ->setPoint(new Point(1321.21, 312312.12))
        ;

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage($collector::class . ': Content unknown');

        $collector->collect($location);
    }
}

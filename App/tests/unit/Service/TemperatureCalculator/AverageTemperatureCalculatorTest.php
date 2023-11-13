<?php

declare(strict_types=1);

namespace App\Tests\unit\Service\TemperatureCalculator;

use App\Entity\Location;
use App\Exceptions\RequestException;
use App\Service\TemperatureCalculator\AverageTemperatureCalculator;
use App\Service\TemperatureCalculator\TemperatureCollectorInterface;
use App\Tests\TestLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AverageTemperatureCalculatorTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testCalculateTemperature(array $collectorOutputs, ?float $expected): void
    {
        $collectorStubs = [];

        foreach ($collectorOutputs as $collectorOutput) {
            $collector = $this->createStub(TemperatureCollectorInterface::class);
            $collector->method('collect')->willReturn($collectorOutput);
            $collectorStubs[] = $collector;
        }

        $mock = new AverageTemperatureCalculator($collectorStubs, $this->createStub(LoggerInterface::class));

        $this->assertSame($expected, $mock->calculateTemperature($this->createStub(Location::class)));
    }

    public static function provideData(): array
    {
        // todo: improve format output
        return [
            [ 'collectorOutputs' => [5.0, 10.0], 'expected' => 7.5 ],
            [ 'collectorOutputs' => [5.0, 10.0, 15.0], 'expected' => 10.0 ],
            [ 'collectorOutputs' => [5.0, 5.5], 'expected' => 5.25 ],
            [ 'collectorOutputs' => [5.9999], 'expected' => 6.0 ],
            [ 'collectorOutputs' => [5.999], 'expected' => 5.999 ],
            [ 'collectorOutputs' => [5.0], 'expected' => 5.0 ],
            [ 'collectorOutputs' => [], 'expected' => null ],
            [ 'collectorOutputs' => [0.0], 'expected' => 0 ],
            [ 'collectorOutputs' => [0.0], 'expected' => 0.0 ],
            [ 'collectorOutputs' => [0.0, 0.0001], 'expected' => 0 ],
            [ 'collectorOutputs' => [10.0, 0.0, 0.0], 'expected' => 3.333 ],
        ];
    }

    public function testLogExceptions(): void
    {
        $errorMessage = 'lorem ipsum';

        $invalidCollector = $this->createStub(TemperatureCollectorInterface::class);
        $invalidCollector->method('collect')->will($this->throwException(new RequestException($errorMessage)));

        $validCollector = $this->createStub(TemperatureCollectorInterface::class);
        $validCollector->method('collect')->willReturn(10.0);

        $logger = new TestLogger();
        $this->assertEquals(0, count($logger->error));

        $mock = new AverageTemperatureCalculator([$invalidCollector, $validCollector], $logger);
        $this->assertSame(10.0, $mock->calculateTemperature($this->createStub(Location::class)));

        $this->assertCount(1, $logger->error);
        $this->assertEquals($errorMessage, $logger->error[0]['message']);
    }
}

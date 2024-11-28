<?php

namespace Tests\Unit;

use App\Contracts\CarbonIntensityApiInterface;
use App\DTO\CarbonIntensityDto;
use App\Exceptions\CarbonIntensityApiException;
use App\Services\CarbonIntensityService;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CarbonIntensityServiceTest extends TestCase
{
    private CarbonIntensityService $service;
    private $apiClientMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClientMock = Mockery::mock(CarbonIntensityApiInterface::class);
        $this->service = new CarbonIntensityService($this->apiClientMock);
    }

    #[Test]
    public function test_it_fetches_carbon_intensity_successfully(): void
    {
        $zone = 'DE';

        $apiResponse = [
            'zone' => $zone,
            'carbonIntensity' => 350,
            'datetime' => '2024-11-26T10:00:00Z',
            'updatedAt' => '2024-11-26T09:55:00Z',
            'createdAt' => '2024-11-26T09:00:00Z',
        ];

        $this->apiClientMock
            ->shouldReceive('fetchCarbonIntensityData')
            ->once()
            ->with($zone)
            ->andReturn($apiResponse);

        $result = $this->service->getCarbonIntensity($zone);

        $this->assertInstanceOf(CarbonIntensityDto::class, $result);
        $this->assertEquals(350, $result->carbonIntensity);
        $this->assertEquals($zone, $result->zone);
    }

    #[Test]
    public function test_it_throws_an_exception_on_failed_api_response(): void
    {
        $zone = 'DE';

        $this->apiClientMock
            ->shouldReceive('fetchCarbonIntensityData')
            ->once()
            ->with($zone)
            ->andThrow(new CarbonIntensityApiException('Failed to fetch carbon intensity data.'));

        $this->expectException(CarbonIntensityApiException::class);
        $this->expectExceptionMessage('Failed to fetch carbon intensity data.');

        $this->service->getCarbonIntensity($zone);
    }

    #[Test]
    public function test_it_handles_missing_carbon_intensity_gracefully(): void
    {
        $zone = 'DE';

        $apiResponse = [
            'zone' => $zone,
            'carbonIntensity' => null,
            'datetime' => '2024-11-26T10:00:00Z',
            'updatedAt' => '2024-11-26T09:55:00Z',
            'createdAt' => '2024-11-26T09:00:00Z',
        ];

        $this->apiClientMock
            ->shouldReceive('fetchCarbonIntensityData')
            ->once()
            ->with($zone)
            ->andReturn($apiResponse);

        $result = $this->service->getCarbonIntensity($zone);

        $this->assertInstanceOf(CarbonIntensityDto::class, $result);
        $this->assertNull($result->carbonIntensity);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

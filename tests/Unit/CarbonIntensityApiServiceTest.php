<?php

namespace Tests\Unit;

use App\Exceptions\CarbonIntensityApiException;
use App\Services\CarbonIntensityApiService;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CarbonIntensityApiServiceTest extends TestCase
{
    private CarbonIntensityApiService $apiService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiService = new CarbonIntensityApiService();
    }

    #[Test]
    public function test_fetches_carbon_intensity_data_successfully(): void
    {
        $zone = 'DE';

        $responseData = [
            'zone' => $zone,
            'carbonIntensity' => 350,
            'datetime' => '2024-11-26T10:00:00Z',
            'updatedAt' => '2024-11-26T09:55:00Z',
            'createdAt' => '2024-11-26T09:00:00Z',
        ];

        Http::fake([
            '*' => Http::response($responseData, 200),
        ]);

        $result = $this->apiService->fetchCarbonIntensityData($zone);

        $this->assertEquals($responseData, $result);
    }

    #[Test]
    public function test_throws_exception_on_failed_api_response(): void
    {
        $zone = 'DE';

        Http::fake([
            '*' => Http::response([], 500),
        ]);

        $this->expectException(CarbonIntensityApiException::class);
        $this->expectExceptionMessage('Error (500): Failed to fetch carbon intensity data.');

        $this->apiService->fetchCarbonIntensityData($zone);
    }
}

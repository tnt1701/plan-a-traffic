<?php

namespace App\Services;

use App\Contracts\CarbonIntensityApiInterface;
use App\Exceptions\CarbonIntensityApiException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CarbonIntensityApiService implements CarbonIntensityApiInterface
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.electricity_maps.base_url');
        $this->token = config('services.electricity_maps.token');
    }

    /**
     * @param string $zone
     * @return array
     * @throws CarbonIntensityApiException
     * @throws ConnectionException
     */
    public function fetchCarbonIntensityData(string $zone): array
    {
        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders(['Authorization' => "Bearer {$this->token}"])
            ->get('/v3/carbon-intensity/latest', ['zone' => $zone]);

        if ($response->failed()) {
            $message = $response->json('error') ?? 'Failed to fetch carbon intensity data.';
            throw new CarbonIntensityApiException("Error ({$response->status()}): {$message}");
        }

        return $response->json();
    }
}

<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\Http;

trait MocksCarbonIntensityApi
{
    protected function mockSuccessfulResponse(int $carbonIntensity, string $zone = 'DE'): void
    {
        Http::fake([
            '*' => Http::response([
                'zone' => $zone,
                'carbonIntensity' => $carbonIntensity,
                'datetime' => '2024-11-26T10:00:00Z',
                'updatedAt' => '2024-11-26T09:55:00Z',
                'createdAt' => '2024-11-26T09:00:00Z',
            ], 200),
        ]);
    }

    protected function mockFailedResponse(int $statusCode = 500, array $responseBody = []): void
    {
        Http::fake([
            '*' => Http::response($responseBody, $statusCode),
        ]);
    }
}

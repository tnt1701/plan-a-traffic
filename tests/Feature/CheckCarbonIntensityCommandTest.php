<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\Traits\MocksCarbonIntensityApi;

class CheckCarbonIntensityCommandTest extends TestCase
{
    use MocksCarbonIntensityApi;

    #[Test]
    public function test_command_displays_correct_output_on_successful_response(): void
    {
        $carbonIntensity = 320;
        $zone = 'DE';
        $trafficLight = 'YELLOW';
        $this->mockSuccessfulResponse($carbonIntensity, $zone);

        $this->artisan('carbon:intensity:check', ['zone' => $zone])
            ->expectsOutput("Current Carbon Intensity: {$carbonIntensity} gCO2eq/kWh")
            ->expectsOutput("Traffic Light: {$trafficLight}")
            ->assertExitCode(0);
    }

    #[Test]
    public function test_command_handles_failed_api_response(): void
    {
        $zone = 'DE';
        $errorMessage = "API Error: Error (500): Failed to fetch carbon intensity data.";
        $this->mockFailedResponse();

        $this->artisan('carbon:intensity:check', ['zone' => $zone])
            ->expectsOutput($errorMessage)
            ->assertExitCode(1);
    }
}

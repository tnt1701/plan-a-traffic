<?php

namespace Tests\Unit;

use App\Enums\TrafficLight;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TrafficLightTest extends TestCase
{
    #[Test]
    public function testRedLightForHighCarbonIntensity(): void
    {
        $carbonIntensity = 500;

        $result = TrafficLight::determineTrafficLighting($carbonIntensity);

        $this->assertSame(TrafficLight::RED, $result);
    }

    #[Test]
    public function testYellowLightForModerateCarbonIntensity(): void
    {
        $carbonIntensity = 300;

        $result = TrafficLight::determineTrafficLighting($carbonIntensity);

        $this->assertSame(TrafficLight::YELLOW, $result);
    }

    #[Test]
    public function testGreenLightForLowCarbonIntensity(): void
    {
        $carbonIntensity = 150;

        $result = TrafficLight::determineTrafficLighting($carbonIntensity);

        $this->assertSame(TrafficLight::GREEN, $result);
    }
}

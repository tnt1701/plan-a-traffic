<?php

namespace App\Enums;

enum TrafficLight: string
{
    case RED = 'red';
    case GREEN = 'green';
    case YELLOW = 'yellow';

    public static function determineTrafficLighting(int $carbonIntensity): self
    {
        return match (true) {
            $carbonIntensity > 400 => self::RED,
            $carbonIntensity < 200 => self::GREEN,
            default => self::YELLOW,
        };
    }
}

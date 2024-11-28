<?php

namespace App\DTO;

readonly class CarbonIntensityDto
{
    public ?string $zone;
    public ?int $carbonIntensity;
    public ?string $datetime;
    public ?string $updatedAt;
    public ?string $createdAt;

    private function __construct(array $data)
    {
        $this->zone = $data['zone'];
        $this->carbonIntensity = $data['carbonIntensity'];
        $this->datetime = $data['datetime'];
        $this->updatedAt = $data['updatedAt'];
        $this->createdAt = $data['createdAt'];
    }

    public static function fromApiResponse(array $data): CarbonIntensityDto
    {
        return new self([
            'zone' => $data['zone'] ?? null,
            'carbonIntensity' => $data['carbonIntensity'] ?? null,
            'datetime' => $data['datetime'] ?? null,
            'updatedAt' => $data['updatedAt'] ?? null,
            'createdAt' => $data['createdAt'] ?? null,
        ]);
    }
}

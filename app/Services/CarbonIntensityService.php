<?php

namespace App\Services;

use App\Contracts\CarbonIntensityApiInterface;
use App\DTO\CarbonIntensityDto;

class CarbonIntensityService
{
    /**
     * @var CarbonIntensityApiInterface
     */
    private CarbonIntensityApiInterface $apiClient;

    /**
     * @param CarbonIntensityApiInterface $apiClient
     */
    public function __construct(CarbonIntensityApiInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param string $zone
     * @return CarbonIntensityDto|null
     */
    public function getCarbonIntensity(string $zone): ?CarbonIntensityDto
    {
        $data = $this->apiClient->fetchCarbonIntensityData($zone);

        return CarbonIntensityDto::fromApiResponse($data);
    }
}

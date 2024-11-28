<?php

namespace App\Contracts;

use App\Exceptions\CarbonIntensityApiException;

interface CarbonIntensityApiInterface
{
    /**
     * Fetches the carbon intensity data for a given zone.
     *
     * @param string $zone
     * @return array
     * @throws CarbonIntensityApiException
     */
    public function fetchCarbonIntensityData(string $zone): array;
}

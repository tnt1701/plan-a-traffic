<?php

namespace App\Console\Commands;

use App\Enums\TrafficLight;
use App\Exceptions\CarbonIntensityApiException;
use App\Services\CarbonIntensityService;
use Illuminate\Console\Command;

class CheckCarbonIntensityCommand extends Command
{
    protected $signature = 'carbon:intensity:check {zone=DE}';
    protected $description = 'Check the current carbon intensity and display the traffic light status';

    /**
     * @var CarbonIntensityService
     */
    private CarbonIntensityService $carbonIntensityService;

    /**
     * @param CarbonIntensityService $carbonIntensityService
     */
    public function __construct(CarbonIntensityService $carbonIntensityService)
    {
        parent::__construct();
        $this->carbonIntensityService = $carbonIntensityService;
    }

    public function handle(): int
    {
        $zone = $this->argument('zone');

        try {
            $carbonIntensityDto = $this->carbonIntensityService->getCarbonIntensity($zone);

            if (!$carbonIntensityDto || !$carbonIntensityDto->carbonIntensity) {
                return $this->handleFailure("Unable to retrieve carbon intensity for the given zone {$zone}");
            }

            $trafficLight = TrafficLight::determineTrafficLighting($carbonIntensityDto->carbonIntensity);

            $this->displayResults($carbonIntensityDto->carbonIntensity, $trafficLight);

            return Command::SUCCESS;
        } catch (CarbonIntensityApiException $e) {
            return $this->handleFailure("API Error: {$e->getMessage()}");
        } catch (\Exception $e) {
            return $this->handleFailure("An unexpected error occurred: {$e->getMessage()}");
        }
    }

    /**
     * @param int $carbonIntensity
     * @param TrafficLight $trafficLight
     * @return void
     */
    private function displayResults(int $carbonIntensity, TrafficLight $trafficLight): void
    {
        $this->info("Current Carbon Intensity: {$carbonIntensity} gCO2eq/kWh");
        $this->line("<fg={$trafficLight->value}>Traffic Light: {$trafficLight->name}</>");
    }

    /**
     * @param string $message
     * @return int
     */
    private function handleFailure(string $message): int
    {
        \Log::error($message);
        $this->error($message);
        return Command::FAILURE;
    }
}

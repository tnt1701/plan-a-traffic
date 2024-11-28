<?php

namespace App\Providers;

use App\Contracts\CarbonIntensityApiInterface;
use App\Services\CarbonIntensityApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(CarbonIntensityApiInterface::class, CarbonIntensityApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

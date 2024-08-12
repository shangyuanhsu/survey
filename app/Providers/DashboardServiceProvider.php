<?php

namespace App\Providers;

use App\Services\DashboardService;
use App\Services\Contracts\DashboardServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider implements DeferrableProvider
{

 
    /**
     * Register services.
     */
    private $contracts;
    public function register()
    {
        $this->app->singleton(DashboardServiceInterface::class, DashboardService::class);
    }

    /**
     * Bootstrap services.
     */
    public function provides()
    {
        return [DashboardServiceInterface::class];
    }
}

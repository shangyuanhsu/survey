<?php

namespace App\Providers;

use App\Repositories\SurveyRepository;
use App\Services\DashboardService;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Services\Contracts\DashboardServiceInterface;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DashboardServiceInterface::class, DashboardService::class);
        $this->app->bind(SurveyRepositoryInterface::class, SurveyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

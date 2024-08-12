<?php

namespace App\Providers;

use App\Services\SurveyService;
use App\Services\Contracts\SurveyServiceInterface;
use App\Repositories\SurveyRepository;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class SurveyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SurveyServiceInterface::class, SurveyService::class);
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

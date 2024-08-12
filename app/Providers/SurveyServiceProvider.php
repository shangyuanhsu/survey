<?php

namespace App\Providers;

use App\Services\SurveyService;
use App\Services\Contracts\SurveyServiceInterface;
use App\Repositories\SurveyRepository;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SurveyServiceProvider extends ServiceProvider 
{
    /**
     * Register services.
     */
    private $contracts;
    public function register()
    {
        $this->app->singleton(SurveyServiceInterface::class, SurveyService::class);
        $this->app->singleton(SurveyRepositoryInterface::class, SurveyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function provides()
    {
        return [
            SurveyServiceInterface::class,
            SurveyRepositoryInterface::class
        ];
    }
}

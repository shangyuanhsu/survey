<?php

namespace App\Providers;

use App\Services\DashboardService;
use App\Services\Contracts\DashboardServiceInterface;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DashboardServiceInterface::class, DashboardService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data) {
            return Response::json([
              'code'  => '000',
              'data' => $data,
            ]);
        });
    }
}

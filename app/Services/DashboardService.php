<?php

namespace App\Services;

use App\Services\Contracts\DashboardServiceInterface;

class DashboardService implements DashboardServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getData()
    {
        
        return [
            'users' => 100,
            'sales' => 200,
        ];
    }
}

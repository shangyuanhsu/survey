<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

interface  DashboardServiceInterface
{    
    /**
     * getDashboardData
     * 
     * Retrieve the user's survey data
     *
     * @param  Model $user 
     * @return array
     */
    public function getDashboardData(Model $user): array;
}

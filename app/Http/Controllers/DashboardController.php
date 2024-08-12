<?php

namespace App\Http\Controllers;

use App\Http\Resources\SurveyAnswerResource;
use App\Http\Resources\SurveyDashboardResource;
use App\Services\Contracts\DashboardServiceInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardServiceInterface $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $dashboardData = $this->dashboardService->getDashboardData($user);

        $total = $dashboardData['total'];
        $latest = $dashboardData['latest'];
        $totalAnswers = $dashboardData['totalAnswers'];
        $latestAnswers = collect($dashboardData['latestAnswers']);

        return [
            'totalSurveys' => $total,
            'latestSurvey' => $latest ? new SurveyDashboardResource($latest) : null,
            'totalAnswers' => $totalAnswers,
            'latestAnswers' => SurveyAnswerResource::collection($latestAnswers)
        ];
    }
}

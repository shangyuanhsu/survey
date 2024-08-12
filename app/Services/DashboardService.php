<?php

namespace App\Services;

use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Services\Contracts\DashboardServiceInterface;
use Illuminate\Database\Eloquent\Model;

class DashboardService implements DashboardServiceInterface
{
    public function __construct(private SurveyRepositoryInterface $surveyRepository) {}

    public function getDashboardData(Model $user): array
    {
        $total = $this->surveyRepository->getTotalSurveys($user->id);
        $latest = $this->surveyRepository->getLatestSurvey($user->id);
        $totalAnswers = $this->surveyRepository->getTotalAnswers($user->id);
        $latestAnswers = $this->surveyRepository->getLatestAnswers($user->id);

        return [
            'total' => $total,
            'latest' => $latest,
            'totalAnswers' => $totalAnswers,
            'latestAnswers' => $latestAnswers,
        ];
    }
}

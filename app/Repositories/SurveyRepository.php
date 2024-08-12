<?php

namespace App\Repositories;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class SurveyRepository implements SurveyRepositoryInterface
{
    public function getTotalSurveys(int $userId): int
    {
        return Survey::query()
            ->where('user_id', $userId)
            ->count();
    }

    public function getLatestSurvey(int $userId): ?Survey
    {
        return Survey::query()
            ->where('user_id', $userId)
            ->latest('created_at')
            ->first();
    }

    public function getTotalAnswers(int $userId): int
    {
        return SurveyAnswer::query()
            ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
            ->where('surveys.user_id', $userId)
            ->count();
    }

    public function getLatestAnswers(int $userId, int $limit = 5): Collection
    {
        return SurveyAnswer::query()
            ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
            ->where('surveys.user_id', $userId)
            ->orderBy('end_date', 'DESC')
            ->limit($limit)
            ->get(['survey_answers.*']);
    }

    public function findByUserId(int $userId): LengthAwarePaginator
    {
        return Survey::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(3);
    }

    public function createSurvey(array $surveyAttributes): Survey
    {
        return Survey::create($surveyAttributes);
    }

    public function createSurveyQuestion($validator): SurveyQuestion
    {
        return SurveyQuestion::create($validator);
    }
}

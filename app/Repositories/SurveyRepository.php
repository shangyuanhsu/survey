<?php

namespace App\Repositories;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function createSurveyQuestion(array $validator): SurveyQuestion
    {
        return SurveyQuestion::create($validator);
    }

    public function updateSurvey(int $id, array $surveyAttributes): bool
    {
        return Survey::find($id)
            ->update($surveyAttributes);
    }

    public function destroySurveyQuestion(array $ids): bool
    {
        return SurveyQuestion::destroy($ids);
    }

    public function createSurveyAnswer(array $surveyAnswerAttributes): SurveyAnswer
    {
        return SurveyAnswer::create($surveyAnswerAttributes);
    }

    public function createSurveyQuestionAnswer(array $surveyQuestionAnswerAttributes): SurveyQuestionAnswer
    {
        return SurveyQuestionAnswer::create($surveyQuestionAnswerAttributes);
    }
}

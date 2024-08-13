<?php

namespace App\Repositories\Contracts;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SurveyRepositoryInterface
{
    /**
     * getTotalSurveys
     * 
     * Total Number of Surveys
     *
     * @param  int $userId
     * @return int
     */
    public function getTotalSurveys(int $userId): int;

    /**
     * getLatestSurvey
     * 
     * Latest Survey
     *
     * @param  int $userId
     * @return Survey
     */
    public function getLatestSurvey(int $userId): ?Survey;

    /**
     * getTotalAnswers
     * 
     * Total Number of answers
     *
     * @param  int $userId
     * @return int
     */
    public function getTotalAnswers(int $userId): int;

    /**
     * getLatestAnswers
     * 
     * Latest 5 answer
     *
     * @param  int $userId
     * @param  int $limit
     * @return Collection<SurveyAnswer>
     */
    public function getLatestAnswers(int $userId, int $limit = 5): Collection;

    /**
     * findByUserId
     *
     * @param  int $userId
     * @return LengthAwarePaginator
     */
    public function findByUserId(int $userId): LengthAwarePaginator;

    /**
     * createSurvey
     *
     * @param  array $userId
     * @return Survey
     */
    public function createSurvey(array $surveyAttributes): Survey;

    /**
     * createSurveyQuestion
     *
     * @param  array $validator
     * @return SurveyQuestion
     */
    public function createSurveyQuestion(array $validator): SurveyQuestion;

    /**
     * updateSurvey
     *
     * @param  int $id
     * @param  array $surveyAttributes
     * @return bool
     */
    public function updateSurvey(int $id, array $surveyAttributes): bool;

    /**
     * destroySurveyQuestion
     *
     * @param  array $ids
     * @return bool
     */
    public function destroySurveyQuestion(array $ids): bool;

    /**
     * createSurveyAnswer
     *
     * @param  array $surveyAnswerAttributes
     * @return SurveyAnswer
     */
    public function createSurveyAnswer(array $surveyAnswerAttributes): SurveyAnswer;

    /**
     * createSurveyQuestionAnswer
     *
     * @param  array $surveyQuestionAnswerAttributes
     * @return SurveyQuestionAnswer
     */
    public function createSurveyQuestionAnswer(array $surveyQuestionAnswerAttributes): SurveyQuestionAnswer;
}

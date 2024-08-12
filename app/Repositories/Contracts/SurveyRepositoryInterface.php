<?php

namespace App\Repositories\Contracts;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

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
    public function createSurveyQuestion($validator): SurveyQuestion;
}

<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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
     * @return void
     */
    public function getLatestSurvey(int $userId);

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
     * @return Collection
     */
    public function getLatestAnswers(int $userId, int $limit = 5): Collection;

    /**
     * getSurveysByUserId
     *
     * @param  int $userId
     * @return LengthAwarePaginator
     */
    public function getSurveysByUserId(int $userId): LengthAwarePaginator;
}

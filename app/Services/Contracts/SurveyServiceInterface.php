<?php

namespace App\Services\Contracts;

use App\Models\Survey;
use Illuminate\Pagination\LengthAwarePaginator;

interface  SurveyServiceInterface
{
    /**
     * index
     *
     * Display a listing of the resource.
     * 
     * @param  int $userId
     * @return LengthAwarePaginator
     */
    public function getByUserId(int $userId): LengthAwarePaginator;

    /**
     * store
     * 
     * Store a newly created resource in storage.
     *
     * @param  array $surveyAttributes
     * @return Survey
     */
    public function handleSurvey(array $surveyAttributes): Survey;

    /**
     * update
     * 
     * Update the specified resource in storage.
     *
     * @param  Survey $survey
     * @param  array $surveyAttributes
     * @return Survey
     */
    public function updateSurvey(Survey $survey, array $surveyAttributes): Survey;

    /**
     * destroy
     * 
     * Remove the specified resource from storage.
     *
     * @param  Survey $survey
     * @return bool
     */
    public function destroySurvey(Survey $survey): bool;

    /**
     * storeAnswer
     * 
     * Save Survey Answers.
     *
     * @param  Survey $survey
     * @param  array $data
     * @return array
     */
    public function storeAnswer(Survey $survey, array $data): array;
}

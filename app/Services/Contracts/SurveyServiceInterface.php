<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return Model
     */
    public function handleSurvey(array $surveyAttributes): Model;

    // /**
    //  * show
    //  * 
    //  * Display the specified resource.
    //  *
    //  * @param  Model $survey
    //  * @param  Request $request
    //  * @return Response
    //  */
    // public function show(Model $survey, Request $request): Response;


    // /**
    //  * update
    //  * 
    //  * Update the specified resource in storage.
    //  *
    //  * @param  Survey $survey
    //  * @param  array $surveyAttributes
    //  * @return Response
    //  */
    // public function update( Survey $survey, array $surveyAttributes);

    // /**
    //  * destroy
    //  * 
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  Model $survey
    //  * @param  Request $request
    //  * @return Response
    //  */
    // public function destroy(Model $survey, Request $request): Response;

    // /**
    //  * getBySlug
    //  * 
    //  * 
    //  *
    //  * @param  Model $survey
    //  * @return Response
    //  */
    // public function getBySlug(Model $survey): Response;

    // /**
    //  * storeAnswer
    //  * 
    //  * Save Survey Answers.
    //  *
    //  * @param  Request $request
    //  * @param  Model $survey
    //  * @return response
    //  */
    // public function storeAnswer(Request $request, Model $survey): response;
}

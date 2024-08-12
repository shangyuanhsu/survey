<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface  SurveyServiceInterface
{
    /**
     * index
     *
     * Display a listing of the resource.
     * 
     * @param  Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection;

    // /**
    //  * store
    //  * 
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  Request $request
    //  * @return Response
    //  */
    // public function store(Request $request): Response;

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
    //  * @param  Request $request
    //  * @param  Model $survey
    //  * @return Response
    //  */
    // public function update(Request $request, Model $survey): Response;

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

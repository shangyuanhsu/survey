<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Resources\SurveyResource;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Services\Contracts\SurveyServiceInterface;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function __construct(private SurveyServiceInterface $SurveyService) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $surveysByUserIdData = $this->SurveyService->getByUserId($user->id);

        return SurveyResource::collection($surveysByUserIdData);
    }

    public function store(StoreSurveyRequest $request)
    {
        $data = $request->validated();

        $survey = $this->SurveyService->handleSurvey($data);

        return new SurveyResource($survey);
    }

    public function show(Survey $survey, Request $request)
    {
        $user = $request->user();

        if ($user->id !== $survey->user_id) {
            return abort(403, 'Unauthorized action');
        }

        return new SurveyResource($survey);
    }

    public function update(UpdateSurveyRequest $request, Survey $survey) {

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Resources\SurveyResource;
use App\Http\Requests\StoreSurveyAnswerRequest;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Services\Contracts\SurveyServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function __construct(private SurveyServiceInterface $surveyService) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $surveysByUserIdData = $this->surveyService->getByUserId($user->id);

        return SurveyResource::collection($surveysByUserIdData);
    }

    public function store(StoreSurveyRequest $request)
    {
        $data = $request->validated();

        $survey = $this->surveyService->handleSurvey($data);

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

    public function update(Survey $survey, UpdateSurveyRequest $request)
    {
        $data = $request->validated();

        $survey = $this->surveyService->updateSurvey($survey, $data);

        return  new SurveyResource($survey);
    }

    public function destroy(Survey $survey, Request $request)
    {
        $user = $request->user();

        if ($user->id !== $survey->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        $survey = $this->surveyService->destroySurvey($survey);

        return response('', 204);
    }

    public function getBySlug(Survey $survey)
    {
        if (!$survey->status) {
            return response("", 404);
        }

        $currentDate = Carbon::now();
        $expireDate = Carbon::parse($survey->expire_date);

        if ($currentDate > $expireDate) {
            return response("", 404);
        }

        return new SurveyResource($survey);
    }

    public function storeAnswer(Survey $survey, StoreSurveyAnswerRequest $request)
    {
        $validated = $request->validated();

        $survey = $this->surveyService->storeAnswer($survey, $validated);

        if (!$survey['isSuccess']) {
            return response($survey['msg'], 400);
        }

        return response("", 201);
    }
}

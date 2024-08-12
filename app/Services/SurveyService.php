<?php

namespace App\Services;

use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Services\Contracts\SurveyServiceInterface;
use App\Http\Resources\SurveyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class SurveyService implements SurveyServiceInterface
{
    protected $surveyRepository;
    public function __construct(SurveyRepositoryInterface $surveyRepository) {}

    public function index(Request $request):AnonymousResourceCollection
    {
        $user = $request->user();

        $surveysByUserIdData = $this->surveyRepository->getSurveysByUserId($user->id);

        return SurveyResource::collection($surveysByUserIdData);
    }
}

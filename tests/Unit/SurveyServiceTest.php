<?php

use App\Services\SurveyService;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Models\Survey;
use Illuminate\Pagination\LengthAwarePaginator;

describe('SurveyService', function () {
    it('returns surveys by user id', function () {
        $userId = 1;
        $mockPaginator = mock(LengthAwarePaginator::class);

        $surveyRepository = mock(SurveyRepositoryInterface::class);
        $surveyRepository->shouldReceive('findByUserId')
            ->with($userId)
            ->andReturn($mockPaginator);

        $service = new SurveyService($surveyRepository);
        $result = $service->getByUserId($userId);

        expect($result)->toBe($mockPaginator);
    });

    it('deletes a survey', function () {
        $mockSurvey = mock(Survey::class);
        $mockSurvey->shouldReceive('delete')->andReturn(true);
        $mockSurvey->shouldReceive('getAttribute')->with('image')->andReturn(null);
        
        $surveyRepository = mock(SurveyRepositoryInterface::class);

        $service = new SurveyService($surveyRepository);
        $result = $service->destroySurvey($mockSurvey);

        expect($result)->toBe(true);
    });
});

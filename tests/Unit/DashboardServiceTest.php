<?php

use App\Services\DashboardService;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

describe('DashboardService', function () {
    it('returns dashboard data for a user', function () {
        // Create a mock user
        $user = new class extends Model {
            public $id = 1;
        };

        // Create mock Survey and SurveyAnswer models
        $mockSurvey = mock(Survey::class);
        $mockSurvey->shouldReceive('setAttribute')->andReturnNull();
        $mockSurvey->id = 10;
        $mockSurvey->title = 'Latest Survey';

        $mockAnswer1 = mock(SurveyAnswer::class);
        $mockAnswer1->shouldReceive('setAttribute')->andReturnNull();
        $mockAnswer1->id = 100;
        $mockAnswer1->answer = 'Answer A';

        $mockAnswer2 = mock(SurveyAnswer::class);
        $mockAnswer2->shouldReceive('setAttribute')->andReturnNull();
        $mockAnswer2->id = 101;
        $mockAnswer2->answer = 'Answer B';

        $mockAnswersCollection = new Collection([$mockAnswer1, $mockAnswer2]);

        // Mock the repository
        $surveyRepository = mock(SurveyRepositoryInterface::class);
        $surveyRepository->shouldReceive('getTotalSurveys')
            ->with(1)
            ->andReturn(5);
            
        $surveyRepository->shouldReceive('getLatestSurvey')
            ->with(1)
            ->andReturn($mockSurvey);
            
        $surveyRepository->shouldReceive('getTotalAnswers')
            ->with(1)
            ->andReturn(20);
            
        $surveyRepository->shouldReceive('getLatestAnswers')
            ->with(1)
            ->andReturn($mockAnswersCollection);

        // Test the service
        $service = new DashboardService($surveyRepository);
        $result = $service->getDashboardData($user);

        // Assertions
        expect($result)->toBeArray();
        expect($result)->toHaveKeys(['total', 'latest', 'totalAnswers', 'latestAnswers']);
        expect($result['total'])->toBe(5);
        expect($result['latest'])->toBe($mockSurvey);
        expect($result['totalAnswers'])->toBe(20);
        expect($result['latestAnswers'])->toBe($mockAnswersCollection);
    });

    it('handles null latest survey', function () {
        $user = new class extends Model {
            public $id = 2;
        };

        $mockAnswersCollection = new Collection();

        $surveyRepository = mock(SurveyRepositoryInterface::class);
        $surveyRepository->shouldReceive('getTotalSurveys')->with(2)->andReturn(0);
        $surveyRepository->shouldReceive('getLatestSurvey')->with(2)->andReturn(null);
        $surveyRepository->shouldReceive('getTotalAnswers')->with(2)->andReturn(0);
        $surveyRepository->shouldReceive('getLatestAnswers')->with(2)->andReturn($mockAnswersCollection);

        $service = new DashboardService($surveyRepository);
        $result = $service->getDashboardData($user);

        expect($result['total'])->toBe(0);
        expect($result['latest'])->toBeNull();
        expect($result['totalAnswers'])->toBe(0);
        expect($result['latestAnswers'])->toBeInstanceOf(Collection::class);
        expect($result['latestAnswers'])->toHaveCount(0);
    });
});

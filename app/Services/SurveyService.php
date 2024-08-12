<?php

namespace App\Services;

use App\Enums\QuestionTypeEnum;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Services\Contracts\SurveyServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use App\Models\SurveyQuestion;



class SurveyService implements SurveyServiceInterface
{
    public function __construct(private SurveyRepositoryInterface $surveyRepository) {}

    public function getByUserId(int $userId): LengthAwarePaginator
    {
        return $this->surveyRepository->findByUserId($userId);
    }

    public function handleSurvey(array $surveyAttributes): Model
    {
        // Check if image was given and save on local file system
        if (isset($surveyAttributes['image'])) { //storage
            $surveyAttributes['image'] = $this->saveImage($surveyAttributes['image']);
        }

        $survey = $this->surveyRepository->createSurvey($surveyAttributes);

        // Create new questions
        foreach ($surveyAttributes['questions'] as $question) {
            $question['survey_id'] = $survey->id;
            $this->createQuestion($question);
        }

        return $survey;
    }


    /**
     * Save image in local file system and return saved image path
     */
    private function saveImage($image): string
    {
        return '';
    }

    /**
     * Create a question and return
     */
    private function createQuestion($data): SurveyQuestion
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }
        $validator = Validator::make($data, [
            'question' => 'required|string',
            'type' => [
                'required',
                new Enum(QuestionTypeEnum::class)
            ],
            'description' => 'nullable|string',
            'data' => 'present',
            'survey_id' => 'exists:App\Models\Survey,id'
        ]);

        $surveyQuestionValidator = $this->surveyRepository->createSurveyQuestion(
            $validator->validated()
        );

        return $surveyQuestionValidator;
    }


}

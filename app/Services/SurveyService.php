<?php

namespace App\Services;

use App\Enums\QuestionTypeEnum;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Services\Contracts\SurveyServiceInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class SurveyService implements SurveyServiceInterface
{
    public function __construct(private SurveyRepositoryInterface $surveyRepository) {}

    public function getByUserId(int $userId): LengthAwarePaginator
    {
        return $this->surveyRepository->findByUserId($userId);
    }

    public function handleSurvey(array $surveyAttributes): Survey
    {
        // Check if image was given and save on local file system
        if (isset($surveyAttributes['image'])) {
            $path = $this->saveImage($surveyAttributes['image']);
            $surveyAttributes['image'] = 'storage/' . $path;
        }

        $survey = $this->surveyRepository->createSurvey($surveyAttributes);

        // Create new questions
        foreach ($surveyAttributes['questions'] as $question) {
            $question['survey_id'] = $survey->id;
            $this->createQuestion($question);
        }

        return $survey;
    }

    public function updateSurvey(Survey $survey, array $surveyAttributes): Survey
    {
        if (isset($surveyAttributes['image'])) {
            $relativePath = $this->saveImage($surveyAttributes['image']);
            $surveyAttributes['image'] = 'storage/' . $relativePath;

            if ($survey->image) {
                Storage::disk('public')->delete($survey->image);
            }
        }

        $this->surveyRepository->updateSurvey($survey->id, $surveyAttributes);

        $existingIds = $survey->questions()->pluck('id')->toArray();
        $newIds = Arr::pluck($surveyAttributes['questions'], 'id');

        $toDelete = array_diff($existingIds, $newIds);
        $toAdd = array_diff($newIds, $existingIds);


        $this->surveyRepository->destroySurveyQuestion($toDelete);

        // Create new questions
        foreach ($surveyAttributes['questions'] as $question) {
            if (in_array($question['id'], $toAdd)) {
                $question['survey_id'] = $survey->id;
                $this->createQuestion($question);
            }
        }

        // Update existing questions
        $questionMap = collect($surveyAttributes['questions'])->keyBy('id');

        foreach ($survey->questions as $question) {
            if (isset($questionMap[$question->id])) {
                $this->updateQuestion($question, $questionMap[$question->id]);
            }
        }

        return $survey;
    }

    public function destroySurvey(Survey $survey): bool
    {
        $isDestroy = true;
        try {
            $survey->delete();

            if ($survey->image) {
                Storage::disk('public')->delete($survey->image);
            }
        } catch (\Throwable $th) {
            $isDestroy = false;
        }
        return $isDestroy;
    }

    public function storeAnswer(Survey $survey, array $data): array
    {
        $res = [
            'isSuccess' => false,
            'msg' => '',
        ];

        try {

            $surveyAnswerData = [
                'survey_id' => $survey->id,
                'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'end_date' => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            $surveyAnswer = $this->surveyRepository->createSurveyAnswer($surveyAnswerData);


            foreach ($data['answers'] as $questionId => $answer) {
                $question = SurveyQuestion::where(['id' => $questionId, 'survey_id' => $survey->id])->get();
                if (!$question) {
                    throw new \Exception("Invalid question ID: \"$questionId\"");
                }

                $data = [
                    'survey_question_id' => $questionId,
                    'survey_answer_id' => $surveyAnswer->id,
                    'answer' => is_array($answer) ? json_encode($answer) : $answer
                ];

                $this->surveyRepository->createSurveyQuestionAnswer($data);
            }
        } catch (\Throwable $th) {
            $res['msg'] = $th->getMessage();
        }

        $res = [
            'isSuccess' => true,
            'msg' => 'Success',
        ];

        return $res;
    }

    /**
     * Save image in local file system and return saved image path
     */
    private function saveImage($image): string
    {
        // Check if the image is a valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Extract the base64 encoded text without the MIME type
            $image = substr($image, strpos($image, ',') + 1);
            // Get the file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if the file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('Invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('Base64 decoding failed');
            }
        } else {
            throw new \Exception('Did not match data URI with image data');
        }

        // Generate a random file name
        $file = Str::random(40) . '.' . $type;
        // Define the image storage path
        $path = 'images/' . $file;

        // Use Laravel's Storage facade to store the image
        Storage::disk('public')->put($path, $image);

        return $path;
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

    /**
     * update a question
     */
    private function updateQuestion(SurveyQuestion $question, array $data): bool
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }

        $validator = Validator::make($data, [
            'id' => 'exists:App\Models\SurveyQuestion,id',
            'question' => 'required|string',
            'type' => ['required', new Enum(QuestionTypeEnum::class)],
            'description' => 'nullable|string',
            'data' => 'present',
        ]);

        return $question->update($validator->validated());
    }
}

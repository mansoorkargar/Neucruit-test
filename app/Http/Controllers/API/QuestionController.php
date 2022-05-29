<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Classes\Contracts\Services\QuestionService;

class QuestionController extends APIController
{
    /**
     * @param QuestionService $questionService
     * @return array
     */
    public function list(QuestionService $questionService): array
    {
        return $questionService->list();
    }

    /**
     * @param QuestionService $questionService
     * @return array
     */
    public function listOfTypes(QuestionService $questionService): array
    {
        return $questionService->listOfTypes();
    }

    /**
     * Save questions
     *
     * @param QuestionRequest $request
     *
     * @return array
     */
    public function store(QuestionRequest $request, QuestionService $questionService): JsonResponse
    {
        $question = $questionService->store(
            $request->validated(),
            auth()->user()
        );

        return $this->response([
            'success' => true,
            'token'   => auth()->user()->createToken('auth_token')->plainTextToken,
            'user'    => auth()->user(),
            'data'    => new QuestionResource($question)
        ]);
    }

    /**
     * @param Request $request
     * @param QuestionService $questionService
     * @return array
     */
    public function storeAnswers(Request $request, QuestionService $questionService): array
    {
        return $questionService->storeAnswers($request);
    }
}

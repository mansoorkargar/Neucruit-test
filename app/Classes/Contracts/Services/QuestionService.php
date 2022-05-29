<?php

namespace App\Classes\Contracts\Services;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;

interface QuestionService
{
    /**
     * @param array $data
     * @param User $user
     * @return Question
     */
    public function store(array $data, User $user): Question;

    /**
     * @return array
     */
    public function list(): array;

    /**
     * @return array
     */
    public function listOfTypes(): array;

    /**
     * @param Request $request
     * @return array
     */
    public function storeAnswers(Request $request): array;
}

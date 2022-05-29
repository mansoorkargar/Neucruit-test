<?php

namespace App\Observers;

use App\Models\Answer;
use App\Models\SignUpQuestion;

class AnswerObserver
{
    /**
     * Listen to the creating event
     *
     * @param Answer $model Answer
     *
     * @return void
     */
    public function creating(Answer $model): void
    {
        $signUpQuestion  = SignUpQuestion::find($model->question_id);
        $model->question = $signUpQuestion->question ?? '';
    }
}

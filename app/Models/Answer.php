<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id',
       'question_id',
       'question',
       'answer',
    ];

    /**
     * User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Question
     *
     * @return BelongsTo
     */
    public function sign_up_question(): BelongsTo
    {
        return $this->belongsTo(SignUpQuestion::class);
    }
}

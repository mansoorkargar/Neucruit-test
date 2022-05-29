<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'id',
        'recruiting',
        'study_question',
        'study_description',
        'copy_paste',
        'study_link',
        'study_minutes',
        'study_start',
        'study_end',
        'participants',
        'looking_for',
        'study_part',
        'notes',
        'questions',
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
}

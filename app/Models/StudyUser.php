<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyUser extends Pivot
{
    protected $table = 'study_user';

    public $timestamps = null;

    /**
     * Study
     *
     * @return BelongsTo
     */
    public function study(): BelongsTo
    {
        return $this->belongsTo(Study::class);
    }

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
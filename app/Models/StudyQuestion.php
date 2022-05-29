<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    protected $table = 'studies_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'study_id',
        'position',
        'name',
        'type',
        'options',
        'ineligible_options',
        'is_required',
    ];

    /**
     * Study
     *
     * @return BelongsTo
     */
    public function study(): BelongsTo
    {
        return $this->belongsTo(Study::class);
    }
}

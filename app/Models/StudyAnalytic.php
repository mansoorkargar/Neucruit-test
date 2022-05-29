<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyAnalytic extends Model
{
    protected $table = 'study_analytics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'study_id',
        'action',
        'channel_id',
        'session_id',
    ];

    /**
     * Dates
     */
    protected $dates = [
        'created_at',
        'updated_at',
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

    /**
     * Participant
     *
     * @return BelongsTo
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * Campaign
     *
     * @return BelongsTo
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(StudyChannel::class);
    }
}

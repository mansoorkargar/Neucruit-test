<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'study_id',
        'name',
        'type',
        'slug',
        'starts_at',
        'ends_at'
    ];

    /**
     * Dates.
     *
     * @var array
     */
    protected $dates = [
        'starts_at',
        'ends_at'
    ];

    /**
     * @return HasMany
     */
    public function study(): BelongsTo
    {
        return $this->belongsTo(Study::class, 'study_id');
    }

    /**
     * Get status
     *
     * @return void
     */
    public function getStatus() {
        if ($this->starts_at <= now()) {
            if ($this->ends_at >= now()) {
                return __('global.in_progress');
            } else {
                return __('global.completed');
            }
        } else {
            return __('global.upcoming');
        }
    }
}

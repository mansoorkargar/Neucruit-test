<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    /**
     * Fillable columns
     * 
     * @var string[]
     */
    protected $fillable = [
        'email',
        'token',
        'study_id',
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
     * Dates
     * 
     * @var array
     */
    public $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Is invitation expired?
     *
     * @return bool
     */
    public function isExpired(): bool {
        return $this->updated_at->diffInDays(now()) > 1 ? true : false;
    }

    /**
     * Get first letter
     *
     * @return string
     */
    public function getFirstLetter(): string
    {
        return mb_strtoupper(
            substr(
                ucfirst(
                    $this->email
                ),
                0,
                1
            )
        );
    }
}

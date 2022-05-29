<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'study_id',
        'status_id',
        'gender_id',
        'reference_number',
        'name',
        'email',
        'age',
        'ethnicity',
        'phone_number',
        'country',
        'birthdate',
        'json',
        'created_at',
        'updated_at',
    ];

    /**
     * Dates
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'json' => 'array',
    ];

    /**
     * Gender
     *
     * @return BelongsTo
     */
    public function study(): BelongsTo
    {
        return $this->belongsTo(Study::class);
    }

    /**
     * Gender
     *
     * @return BelongsTo
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Statuses::class);
    }

    /**
     * Emails
     * 
     * @return BelongsTo
     */
    public function emails(): HasMany
    {
        return $this->hasMany(ParticipantEmails::class, 'participant_id');
    }
}

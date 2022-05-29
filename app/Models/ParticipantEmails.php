<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParticipantEmails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'participant_id',
        'study_id',
        'email_type_id',
    ];

    /**
     * @return BelongsTo
     */
    public function study(): BelongsTo
    {
        return $this->BelongsTo(Study::class,'study_id');
    }

    /**
     * @return BelongsTo
     */
    public function participant(): BelongsTo
    {
        return $this->BelongsTo(Participant::class, 'participant_id');
    }

    /**
     * @return BelongsTo
     */
    public function emailTypes(): BelongsTo
    {
        return $this->BelongsTo(ParticipantEmailsTypes::class, 'email_type_id');
    }
}

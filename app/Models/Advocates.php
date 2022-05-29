<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class User
 * @package App\Models
 */
class Advocates extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'study_id',
        'name',
        'specialty',
        'status',
        'role',
        'country',
        'state',
        'city',
        'address',
        'contact_number',
        'email',
        'gender',
        'total_experience',
        'board_certification',
        'board',
        'handle',
        'reach',
        'image_reference',
        'notes',
    ];

    /**
     * @return HasMany
     */
    public function study(): BelongsTo
    {
        return $this->belongsTo(Study::class, 'study_id');
    }
}

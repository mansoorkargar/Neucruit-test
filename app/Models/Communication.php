<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Communication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'study_id',
        'template_name',
        'email_subject',
        'file',
        'enabled',
        'content',
        'communication_trigger_id',
    ];

    /**
     * @return HasMany
     */
    public function study(): BelongsTo
    {
        return $this->belongsTo(Study::class, 'study_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Design extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'designs';

    /**
     * @var string[]
     */
    protected $fillable = [
        'study_id',
        'assets',
        'components',
        'css',
        'html',
        'styles',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'assets' => 'array',
        'components' => 'array',
        'styles' => 'array',
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

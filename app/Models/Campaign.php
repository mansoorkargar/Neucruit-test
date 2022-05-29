<?php

declare (strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_type_id',
        'name',
        'status',
        'description',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
        'social_name'
    ];

    /**
     * The attributes that should be hidden from array.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    /**
     * The type of the Campaign
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(CampaignType::class, 'campaign_type_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        if ($user = auth()->user()) {
            static::saving(function ($model) use ($user) {
                if (!$model->created_by) {
                    $model->created_by = $user->id;
                }
                $model->updated_by = $user->id;
            });
        }
    }
}

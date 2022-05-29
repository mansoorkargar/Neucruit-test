<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * @var string
     */
    protected $table = 'participants_statuses';

    protected $fillable = [
        'name',
        'slug',
    ];
}

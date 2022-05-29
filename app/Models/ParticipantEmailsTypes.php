<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantEmailsTypes extends Model
{
    use HasFactory;

    protected $table = 'participants_email_types';

    protected $fillable = [
        'name'
    ];
}

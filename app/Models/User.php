<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Pktharindu\NovaPermissions\Role;
use Illuminate\Notifications\Notifiable;
use Pktharindu\NovaPermissions\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class User
 * @property string $name
 * @property string $questions
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const PASSWORD_REQUIREMENTS = ['required', 'string', 'min:8', 'max:255'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'last_name',
        'email',
        'password',
        'info_checked',
        'phone_number',
        'company',
        'token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array<string, string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array<string, string>
     */
    protected $with = [
        'questions', 'studies',
    ];

    /**
     * Questions
     *
     * @return HasOne
     */
    public function questions(): HasOne
    {
        return $this->hasOne(Question::class);
    }

    /**
     * Answers
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Studies
     *
     * @return BelongsToMany
     */
    public function studies(): BelongsToMany
    {
        return $this->belongsToMany(Study::class)->using(StudyUser::class);
    }

    /**
     * Role
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check of User has attached Study
     *
     * @param  int|null $id
     * @return void
     */
    public function hasStudy(?int $id): bool
    {
        if (!$id) {
            return false;
        }

        return !!$this->studies()->find($id);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFullName(): string
    {
        return trim(trim($this->name) . ' ' . trim($this->last_name));
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
                    $this->getFullName()
                ),
                0,
                1
            )
        );
    }
}

<?php

namespace App\Classes\Contracts\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface UsersService
{
    /**
     * Get studies by a user
     *
     * @param User $user User
     *
     * @return BelongsToMany
     */
    public function getStudiesByUser(User $user): BelongsToMany;
}

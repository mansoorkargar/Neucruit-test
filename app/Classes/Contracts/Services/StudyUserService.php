<?php

namespace App\Classes\Contracts\Services;

use App\Models\User;
use App\Models\Study;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface StudyUserService
{
    /**
     * Get users by a study
     *
     * @param Study $study Study
     *
     * @return BelongsToMany
     */
    public function getUsersByStudy(Study $study): BelongsToMany;
    
    /**
     * Remove users from a study
     *
     * @param Study $study Study
     * @param User  $user  User
     *
     * @return bool
     */
    public function destroy(Study $study, User $user): bool;
}

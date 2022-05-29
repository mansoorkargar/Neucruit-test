<?php

namespace App\Services;

use App\Models\Study;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Classes\Contracts\Services\StudyUserService as StudyUserServiceContract;
use App\Models\User;

class StudyUserService implements StudyUserServiceContract
{
    /**
     * Get users by a study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return array
     */
    public function getUsersByStudy(
        Study $study,
        ?string $search = null
    ): BelongsToMany {
        $users = $study->users();
        if ($search) {
            $users = $users->where('name',  'like', '%' . $search . '%');
        }

        return $users;
    }

    /**
     * Detach user from a study
     *
     * @param Study $study Study
     * @param User  $User  User
     *
     * @return bool
     */
    public function destroy(Study $study, User $user): bool
    {
        return $study->users()->detach($user->id) ? true : false;
    }
}

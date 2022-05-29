<?php

namespace App\Observers;

use App\Models\StudyUser;
use App\Jobs\StudyUserAddedMailJob;

class StudyUserObserver
{
    /**
     * Listen to the created event
     *
     * @param StudyUser $model StudyUser
     *
     * @return void
     */
    public function created(StudyUser $model): void
    {
        StudyUserAddedMailJob::dispatch($model);
    }
}

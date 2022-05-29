<?php

namespace App\Observers;

use App\Models\Invitation;
use App\Jobs\InviteUserMailJob;

class InvitationObserver
{
    /**
     * Listen to the updated event
     *
     * @param Invitation $model Invitation
     *
     * @return void
     */
    public function updated(Invitation $model): void
    {
        InviteUserMailJob::dispatch($model);
    }
}

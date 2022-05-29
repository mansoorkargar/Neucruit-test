<?php

namespace App\Jobs;

use App\Models\Invitation;
use App\Mail\InviteUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InviteUserMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Invitation
     * 
     * @var Invitation
     */
    private $invitation;

    /**
     * Create a new job instance.
     *
     * @param Invitation $invitation Invitation
     *
     * @return void
     */
    public function __construct(
        Invitation $invitation
    ) {
        $this->invitation = $invitation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->invitation->email)->send(
            new InviteUserMail($this->invitation)
        );
    }
}

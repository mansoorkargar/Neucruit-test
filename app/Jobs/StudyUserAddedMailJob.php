<?php

namespace App\Jobs;

use App\Models\StudyUser;
use Illuminate\Bus\Queueable;
use App\Mail\StudyUserAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StudyUserAddedMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Studyu ser
     * 
     * @var StudyUser
     */
    private $studyUser;

    /**
     * Create a new job instance.
     *
     * @param StudyUser $studyUser Study user relation
     *
     * @return void
     */
    public function __construct(
        StudyUser $studyUser
    ) {
        $this->studyUser = $studyUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->studyUser->user)->send(
            new StudyUserAddedMail($this->studyUser->user, $this->studyUser->study)
        );
    }
}

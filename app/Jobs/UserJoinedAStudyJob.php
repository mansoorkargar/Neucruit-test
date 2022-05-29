<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Study;
use App\Enums\RoleEnum;
use Illuminate\Bus\Queueable;
use App\Mail\UserJoinedAStudyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UserJoinedAStudyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Study
     */
    private $study;

    /**
     * Create a new job instance.
     * 
     * @param Study $study Study
     * @param User  $user  User
     *
     * @return void
     */
    public function __construct(
        User $user,
        Study $study
    ) {
        $this->user  = $user;
        $this->study = $study;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->study->users()->whereRoleId(RoleEnum::CLIENT)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(
                new UserJoinedAStudyMail($this->user, $this->study)
            );
        }
    }
}

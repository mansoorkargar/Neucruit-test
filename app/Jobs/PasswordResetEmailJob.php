<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\PasswordReset;
use App\Mail\PasswordResetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PasswordResetEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var PasswordReset Password Reset model
     */
    private PasswordReset $passwordReset;

    /**
     * Create a new job instance.
     *
     * @param PasswordReset $passwordReset Password Reset eloquent model
     *
     * @return void
     */
    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->passwordReset->email)
            ->send(new PasswordResetMail(['token' => $this->passwordReset->token]));
    }
}

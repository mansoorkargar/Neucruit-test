<?php


namespace App\Mail;

use App\Models\User;
use App\Models\Study;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserJoinedAStudyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Study
     */
    public $study;

    /**
     * UserJoinedAStudyMail constructor.
     *
     * @param User  $user  User
     * @param Study $study Study
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
     * Build the message.
     *
     * @return UserJoinedAStudyMail
     */
    public function build(): UserJoinedAStudyMail
    {
        return $this->from(config('mail.from.address'))
                    ->subject(trans('global.user_joined_a_study'))
                    ->markdown('mails.user_joined_a_study', [
                        'user'  => $this->user,
                        'study' => $this->study,
                    ]);
    }
}

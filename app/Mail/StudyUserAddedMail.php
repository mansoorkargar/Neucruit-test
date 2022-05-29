<?php


namespace App\Mail;

use App\Models\User;
use App\Models\Study;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudyUserAddedMail extends Mailable
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
     * StudyUserAddedMail constructor.
     *
     * @param User $user User
     */
    public function __construct(User $user, Study $study)
    {
        $this->user  = $user;
        $this->study = $study;
    }

    /**
     * Build the message.
     *
     * @return StudyUserAddedMail
     */
    public function build(): StudyUserAddedMail
    {
        return $this->from(config('mail.from.address'))
                    ->subject(trans('global.you_ve_been_added_to_a_study'))
                    ->markdown('mails.study_user_added', [
                        'user'  => $this->user,
                        'study' => $this->study,
                        'url'   => '#',
                    ]);
    }
}

<?php


namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * RequestCreateMail constructor.
     *
     * @param User $user User
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return RegisterNoticeMail
     */
    public function build(): RegisterNoticeMail
    {
        return $this->from(config('mail.from.address'))
                    ->subject(trans('global.new_user_has_signed_up'))
                    ->markdown('mails.register_notice', [
                        'user'    => $this->user,
                        'answers' => $this->user->answers,
                        'url'     => url('/nova/resources/users/' . $this->user->id),
                    ]);
    }
}

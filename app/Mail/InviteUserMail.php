<?php


namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Invitation
     */
    public $invitation;

    /**
     * InviteUserMail constructor.
     *
     * @param Invitation $invitation Invitation
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return InviteUserMail
     */
    public function build(): InviteUserMail
    {
        return $this->from(config('mail.from.address'))
                    ->subject(trans('global.you_re_invited_to_a_study'))
                    ->markdown('mails.invite_user', [
                        'invitation' => $this->invitation,
                        'url'        => url('/register?token=' . $this->invitation->token . '&email=' . $this->invitation->email),
                    ]);
    }
}

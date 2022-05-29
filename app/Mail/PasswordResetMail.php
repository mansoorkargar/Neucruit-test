<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $data;


    /**
     * RequestCreateMail constructor.
     * @param array $data
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        if (empty($data)) {
            throw new \Exception("Data is empty");
        }

        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): PasswordResetMail
    {
            $url = env("APP_URL") . '/reset-password?token=' . $this->data['token'];

            return $this->from(config('mail.from.address'))
                ->subject(trans('global.password_reset_notification'))
                ->markdown('mails.password_reset',
                    [
                        'url' =>  $url,
                    ]);
    }
}

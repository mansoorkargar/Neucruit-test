<?php


namespace App\Mail;

use App\Models\Participant;
use App\Models\Communication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipantMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Participant
     */
    public $participant;

    /**
     * @var Communication
     */
    public $communication;

    /**
     * ParticipantMail constructor.
     *
     * @param Participant   $invitation    Participant
     * @param Communication $communication Communiation
     */
    public function __construct(Participant $participant, Communication $communication)
    {
        $this->participant   = $participant;
        $this->communication = $communication;
    }

    /**
     * Build the message.
     *
     * @return ParticipantMail
     */
    public function build(): ParticipantMail
    {
        return $this->from(config('mail.from.address'))
                    ->subject($this->communication->email_subject)
                    ->markdown('mails.template', [
                        'participant'   => $this->participant,
                        'communication' => $this->communication,
                    ]);
    }
}

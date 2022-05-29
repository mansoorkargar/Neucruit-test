<?php

namespace App\Jobs;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use App\Mail\ParticipantMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParticipantMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Participant
     * 
     * @var Participant
     */
    private $participant;

    /**
     * Type
     * 
     * @var int
     */
    private $type;

    /**
     * Create a new job instance.
     *
     * @param Participant $participant Participant
     * @param int         $type        Type
     *
     * @return void
     */
    public function __construct(
        Participant $participant,
        int $type
    ) {
        $this->participant = $participant;
        $this->type        = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $communicationTemplates = $this->participant
                                       ->study
                                       ->communications()
                                       ->whereCommunicationTriggerId($this->type)
                                       ->get();
                                       
        foreach ($communicationTemplates as $template) {
            Mail::to($this->participant->email)->send(
                new ParticipantMail($this->participant, $template)
            );
        }

        /* Save record */
        $this->participant->emails()->create([
            'study_id'      => $this->participant->study_id,
            'email_type_id' => $this->type,
        ]);
    }
}

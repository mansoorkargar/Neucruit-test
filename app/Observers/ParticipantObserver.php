<?php

namespace App\Observers;

use App\Models\Participant;
use Illuminate\Support\Str;
use App\Jobs\ParticipantMailJob;
use App\Enums\CommunicationTriggerEnum;

class ParticipantObserver
{
    /**
     * Listen to the creating event
     *
     * @param Participant $model Participant
     *
     * @return void
     */
    public function creating(Participant $model): void
    {
        if (!$model->status_id) {
            $model->status_id = CommunicationTriggerEnum::REGISTRATION;
        }
    }

    /**
     * Listen to the created event
     *
     * @param Participant $model Participant
     *
     * @return void
     */
    public function created(Participant $model): void
    {
        if (!$model->reference_number) {
            $model->reference_number = str_pad($model->id, 5, '0', STR_PAD_LEFT) . mb_strtoupper(Str::random(6));
            $model->saveQuietly();
        }

        ParticipantMailJob::dispatch($model, CommunicationTriggerEnum::REGISTRATION);
    }

    /**
     * Listen to the updated event
     *
     * @param Participant $model Participant
     *
     * @return void
     */
    public function updated(Participant $model): void
    {
        if ($model->wasChanged('status_id')) {
            if ($model->email) {
                ParticipantMailJob::dispatch($model, $model->status_id);
            }
        }
    }
}

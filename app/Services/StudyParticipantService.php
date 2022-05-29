<?php

namespace App\Services;

use App\Models\Study;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Classes\Contracts\Services\StudyParticipantService as StudyParticipantServiceContract;
use App\Http\Requests\Study\CreateParticipantRequest;

class StudyParticipantService implements StudyParticipantServiceContract
{
    /**
     * Get participants by a study
     *
     * @param Study   $study Study
     * @param ?string $search Search string
     *
     * @return HasMany
     */
    public function getParticipantsByStudy(
        Study $study,
        ?string $search
    ): HasMany {
        return $study->participants();
    }

    /**
     * Add paticipant to a study
     *
     * @param Study                    $study   Study
     * @param CreateParticipantRequest $request Request body
     *
     * @return HasMany
     */
    public function store(
        Study $study,
        CreateParticipantRequest $participant
    ): Participant {
        return $study->participants()->create($participant->validated());
    }
}

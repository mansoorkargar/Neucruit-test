<?php

namespace App\Classes\Contracts\Services;

use App\Models\Study;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Requests\Study\CreateParticipantRequest;

interface StudyParticipantService
{
    /**
     * Get participants by a study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return HasMany
     */
    public function getParticipantsByStudy(Study $study, ?string $search): HasMany;

    /**
     * Add participant to a store
     *
     * @param Study                    $study   Study
     * @param CreateParticipantRequest $request Request body
     *
     * @return HasMany
     */
    public function store(Study $study, CreateParticipantRequest $request): Participant;
}

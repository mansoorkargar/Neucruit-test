<?php

namespace App\Classes\Contracts\Services;

use App\Models\User;
use App\Models\Study;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface StudyService
{
    /**
     * Get list of studies per user
     *
     * @param User   $user   User
     * @param string $search Search string
     *
     * @return BelongsToMany
     */
    public function list(User $user, ?string $search): BelongsToMany;

    /**
     * @param Study $study
     * @return mixed
     */
    public function invitedList(Study $study);

    /**
     * @param Study $study
     *
     * @return Study
     */
    public function show(Study $study): Study;

    /**
     * Get users by study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return array
     */
    public function getUsersByStudy(Study $study, ?string $search = null): BelongsToMany;

    /**
     * Get participiants by study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return array
     */
    public function getParticipantsByStudy(Study $study, ?string $search = null): HasMany;

    /**
     * @param Study $study
     * @return array
     */
    public function participantsCountries(Study $study): array;

    /**
     * Get participiants by study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return array
     */
    public function allParticipantList(Study $study, ?string $search = null): HasMany;

    /**
     * Get participants by study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return HasMany
     */
    public function getParticipantsByStudyWithStatus(Study $study, ?string $search = null): HasMany;

    /**
     * @param Study       $study
     * @param Participant $participant
     * @param int         $statusId
     * 
     * @return void
     */
    public function changeParticipantStatus(Study $study, Participant $participant, int $statusId): void;
}

<?php

namespace App\Classes\Contracts\Services;

use App\Models\Study;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface StudyInvitationService
{
    /**
     * Get invitations by a study
     *
     * @param Study $study Study
     *
     * @return HasMany
     */
    public function getInvitationsByStudy(Study $study): HasMany;

    /**
     * Invite users to the study
     *
     * @param Study $study  Study
     * @param array $emails Emails
     *
     * @return array
     */
    public function invite(Study $study, array $emails): array;

    /**
     * Resend invitation
     *
     * @param Study      $study      Study
     * @param Invitation $invitation Invitation
     * 
     * @return array
     */
    public function resend(Study $study, Invitation $invitation): bool;

    /**
     * Delete the invitation
     * 
     * @param Study      $study      Study
     * @param Invitation $invitation Invitation
     * 
     * @return bool
     */
    public function destroy(Study $study, Invitation $invitation): bool;
}

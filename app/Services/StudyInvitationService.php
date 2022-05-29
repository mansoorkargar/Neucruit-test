<?php

namespace App\Services;

use App\Models\User;
use App\Models\Study;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Classes\Contracts\Services\StudyInvitationService as StudyInvitationServiceContract;

class StudyInvitationService implements StudyInvitationServiceContract
{
    /**
     * Get invitations by a study
     * 
     * @param Study $study Study
     * 
     * @return HasMany
     */
    public function getInvitationsByStudy(
        Study $study
    ): HasMany {
        return $study->invitations();
    }

    /**
     * Invite users to a study
     *
     * @param Study $study  Study
     * @param array $emails Email addresses
     *
     * @return array
     */
    public function invite(
        Study $study,
        array $emails
    ): array {
        $response = [];

        $users = User::whereIn('email', $emails)->get();
        foreach ($emails as $email) {
            $user = $users->where('email', '=', $email)->first();

            if ($user) {
                if (!$study->users()->whereEmail($email)->exists()) {
                    $study->users()->attach($user);

                    $response[] = [
                        'email'  => $email,
                        'status' => true
                    ];
                } else {
                    $response[] = [
                        'email'  => $email,
                        'status' => false
                    ];
                }
            } else {
                $study->invitations()->firstOrCreate(['email' => $email])->update(['token' => Str::random(30)]);
                
                $response[] = [
                    'email'  => $email,
                    'status' => true
                ];
            }
        }
        return $response;
    }

    /**
     * Resend invitation
     * 
     * @param Study      $study      Study
     * @param Invitation $invitaiton Invitaiton
     * 
     * @return bool
     */
    public function resend(
        Study $study,
        Invitation $invitation
    ): bool {
        $study->invitations()->whereId($invitation->id)->update(['token' => Str::random(30)]);

        return true;
    }

    /**
     * Remove invitation from a study
     * 
     * @param Study      $study      Study
     * @param Invitation $invitaiton Invitaiton
     * 
     * @return bool
     */
    public function destroy(
        Study $study,
        Invitation $invitation
    ): bool {
        $study->invitations()->whereId($invitation->id)->delete();

        return true;
    }
}

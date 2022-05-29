<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Study;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\InvitationResource;
use App\Http\Requests\Study\InviteUserRequest;
use App\Classes\Contracts\Services\StudyInvitationService;

class StudyInvitationsController extends APIController
{
    /**
     * Retrieve a list of invitations
     * 
     * @param Study                  $study   Study
     * @param Request                $request Request
     * @param StudyInvitationService $service Study invitation service
     * 
     * @return JsonResponse
     */
    public function index(
        Study $study,
        Request $request,
        StudyInvitationService $service
    ): JsonResponse {
        return $this->response(
            InvitationResource::collection($service->getInvitationsByStudy($study)->get())
        );
    }

     /**
     * Invite a user
     *
     * @param Study                  $study   Study
     * @param InviteUserRequest      $request Request body
     * @param StudyInvitationService $service Study invitation service
     *
     * @return JsonResponse
     */
    public function invite(
        Study $study,
        InviteUserRequest $request,
        StudyInvitationService $service
    ): JsonResponse {
        return $this->response(
            $service->invite($study, $request->emails)
        );
    }

    /**
     * Resend invitation to a user
     * 
     * @param Study                  $study         Study
     * @param Invitation             $invitation    Invitation
     * @param StudyInvitationService $service Study invitation service
     * 
     * @return JsonResponse
     */
    public function resend(
        Study $study,
        Invitation $invitation,
        StudyInvitationService $service
    ): JsonResponse {
        $service->resend($study, $invitation);

        return $this->response([]);
    }

    /**
     * Remove invitation from a study
     *
     * @param Study                  $study         Study
     * @param Invitation             $invitation    Invitation
     * @param StudyInvitationService $service Study invitation service
     *
     * @return JsonResponse
     */
    public function destroy(
        Study $study,
        Invitation $invitation,
        StudyInvitationService $service
    ): JsonResponse {
        $service->destroy($study, $invitation);
        
        return $this->response([]);
    }
}

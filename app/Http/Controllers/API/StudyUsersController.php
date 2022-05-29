<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Requests\Study\DeleteUserRequest;
use App\Classes\Contracts\Services\StudyUserService;

class StudyUsersController extends APIController
{
    /**
     * Retrieve a list of invitation
     * 
     * @param Study            $study   Study
     * @param Request          $request Request
     * @param StudyUserService $service Study service
     * 
     * @return JsonResponse
     */
    public function index(
        Study $study,
        Request $request,
        StudyUserService $service
    ): JsonResponse {
        return $this->response(
            UserResource::collection($service->getUsersByStudy($study)->get())
        );
    }

    /**
     * Remove a user from a study
     * 
     * @param Study            $study  Study
     * @param Request          $request Request
     * @param StudyUserService $service Study service
     * 
     * @return JsonResponse
     */
    public function destroy(
        Study $study,
        User $user,
        DeleteUserRequest $request,
        StudyUserService $service
    ): JsonResponse {
        $service->destroy($study, $user);

        return $this->response([]);
    }
}

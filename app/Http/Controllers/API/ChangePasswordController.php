<?php

namespace App\Http\Controllers\API;

use App\Classes\Contracts\Services\ChangePasswordService;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;


class ChangePasswordController extends APIController
{
    /**
     * @param ChangePasswordRequest $request
     * @param ChangePasswordService $changePasswordService
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request, ChangePasswordService $changePasswordService): JsonResponse
    {
        return $this->response($changePasswordService->changePassword($request));
    }
}

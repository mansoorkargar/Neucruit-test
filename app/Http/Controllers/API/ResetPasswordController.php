<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Services\User\TokenService;
use App\Services\User\ResetPasswordService;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ForgetPasswordLinkRequest;

/**
 * ResetPasswordController class
 */
class ResetPasswordController extends APIController
{
    /**
     * Method forgot password
     *
     * @param ForgetPasswordLinkRequest $request              Request body of the request
     * @param ResetPasswordService      $resetPasswordService Reset password service
     *
     * @return JsonResponse
     */
    public function forgetPasswordLink(
        ForgetPasswordLinkRequest $request,
        ResetPasswordService $resetPasswordService
    ): JsonResponse {
        $resetPasswordService->generateForgottenPasswordLink($request);

        return $this->response([
            'message' => __('passwords.sent')
        ]);
    }

    /**
     * Handle reset password
     *
     * @param ResetPasswordRequest $request              Request body of the request
     * @param ResetPasswordService $resetPasswordService Reset password service
     *
     * @return JsonResponse
     */
    public function resetPassword(
        ResetPasswordRequest $request,
        ResetPasswordService $resetPasswordService
    ): JsonResponse {
        $user = $resetPasswordService->resetPassword($request);

        return $this->response([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user'  => $user,
        ]);
    }
}

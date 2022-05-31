<?php

declare(strict_types=1);

namespace app\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\User\TokenService;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\GenerateTokenRequest;
use App\Classes\Contracts\Services\RegisterService;

/**
 * AuthController class
 */
class AuthController extends APIController
{
    /**
     * Login method. Implements sanctum authentication.
     *
     * @param GenerateTokenRequest $request      Request body of the request
     * @param TokenService         $tokenService Token Service
     *
     * @return JsonResponse
     */
    public function login(
        GenerateTokenRequest $request,
        TokenService $tokenService
    ): JsonResponse {
        $token = $tokenService->generate($request);
        if ($token) {
            return $this->response([
                'success' => true,
                'token' => $token,
                'user'  => new UserResource(auth()->user())
            ], 200);
        }

        return $this->response(['message' => __('auth.failed')], 401);
    }

    /**
     * Register a user
     *
     * @param RegisterRequest $request Request body
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, RegisterService $registerService): JsonResponse
    {
        return $this->response(
            $registerService->register($request)
        );
    }

    /**
     * @param Request $request
     * @param RegisterService $registerService
     * @return JsonResponse
     */
    public function getInvitedUser (Request $request, RegisterService $registerService): JsonResponse
    {
        return $this->response(
            $registerService->getInvitedUser($request)
        );
    }

    /**
     * @param Request $request
     * @param RegisterService $registerService
     * @return JsonResponse
     */
    public function registerInvitedUser(Request $request, RegisterService $registerService): JsonResponse
    {
        return $this->response(
            $registerService->registerInvitedUser($request)
        );
    }

    /**
     * Logout method. Revoke auth token for current device only.
     *
     * @param Request      $request      Request body of the request
     * @param TokenService $tokenService Token Service
     *
     * @return JsonResponse
     */
    public function logout(
        Request $request,
        TokenService $tokenService
    ): JsonResponse {
        $tokenService->delete($request);

        return $this->response([], 204);
    }
}

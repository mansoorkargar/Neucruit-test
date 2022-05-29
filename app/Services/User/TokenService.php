<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Http\Requests\User\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\Http\Requests\User\GenerateTokenRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class TokenService
 */
class TokenService
{
    /**
     * Generate a new user token
     *
     * @param GenerateTokenRequest $request Request body
     *
     * @return ?string
     */
    public function generate(GenerateTokenRequest $request): ?string
    {
        if (!auth()->attempt($request->validated())) {
            return null;
        }

        // Check user studies
        if (!auth()->user()->studies->count()) {
            abort(403, __('auth.studies'));
        }

        return auth()->user()->createToken('auth_token')->plainTextToken;
    }

    /**
     * Generate a new user token
     *
     * @param ResetPasswordRequest $request Request body
     *
     * @return ?string
     */
    public function generateToken(ResetPasswordRequest $request): ?string
    {
        if (!auth()->attempt($request->validated())) {
            return null;
        }

        // Check user studies
        if (!auth()->user()->studies->count()) {
            abort(403, __('auth.studies'));
        }

        return auth()->user()->createToken('auth_token')->plainTextToken;
    }

    /**
     * Delete user token
     *
     * @param Request $request Request body
     *
     * @return void
     */
    public function delete(Request $request): void
    {
        $user = auth()->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id ?? null)->delete();

        auth()->guard('web')->logout();
    }
}

<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Jobs\PasswordResetEmailJob;
use App\Exceptions\ResetPasswordException;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ForgetPasswordLinkRequest;

/**
 * Class ResetPasswordService
 */
class ResetPasswordService
{
    /**
     * Generate a new forgotted link email
     *
     * @param ForgetPasswordLinkRequest $request Request body
     *
     * @return bool
     */
    public function generateForgottenPasswordLink(ForgetPasswordLinkRequest $request): bool
    {
        $user = User::whereEmail($request->email)->first();
        if ($user) {
            PasswordResetEmailJob::dispatch(
                PasswordReset::create(
                    array_merge(
                        $request->validated(),
                        ['token' => Str::random(60)]
                    )
                )
            );

            return true;
        }

        return false;
    }

    /**
     * Reset password
     *
     * @param ResetPasswordRequest $request Request body
     *
     * @return User
     */
    public function resetPassword(ResetPasswordRequest $request): User
    {
        $passwordResetToken = PasswordReset::where('created_at', '>=', Carbon::parse('-15 minutes')->format('Y-m-d H:i:s'))
                                           ->whereToken($request->token)
                                           ->first();
        if (!$passwordResetToken) {
            throw new ResetPasswordException(
                'Password reset',
                'Token not found or not valid',
                ['request' => $request->all()],
                422
            );
        }

        $user = User::whereEmail($passwordResetToken->email)->first();
        if (!$user) {
            throw new ResetPasswordException(
                'Password reset',
                'User not found',
                ['request' => $request->all()],
                422
            );
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return $user;
    }
}

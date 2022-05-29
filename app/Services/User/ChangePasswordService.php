<?php


namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Classes\Contracts\Services\ChangePasswordService as ChangePasswordServiceContract;


class ChangePasswordService implements ChangePasswordServiceContract
{
    /**
     * @param ChangePasswordRequest $request
     * @return array
     */
    public function changePassword(ChangePasswordRequest $request): array
    {
        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            User::query()->where('email', $user->email)->firstOrFail()->update([
                'password' => Hash::make($request->password)
            ]);
            return [
                'success' => true,
                'message' => 'Password updated!'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Current password is wrong !'
            ];
        }
    }
}

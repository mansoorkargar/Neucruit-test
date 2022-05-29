<?php


namespace App\Services;

use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\UserJoinedAStudyJob;
use App\Classes\Contracts\Services\RegisterService as RegisterServiceContract;

class RegisterService implements RegisterServiceContract
{
    /**
     * Register a user
     *
     * @param Request $request
     *
     * @return User
     */
    public function register(Request $request): array
    {
        $invitation = Invitation::whereToken($request->token)->first();

        $user = User::create([
            'name'         => $request->name,
            'last_name'    => $request->last_name,
            'company'      => $request->company,
            'phone_number' => $request->phone_number,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'role_id'      => $invitation ? RoleEnum::CLINICAL_STAFF : RoleEnum::CLIENT,
            'info_checked' => ($request->info_checked ?? null) ? 1 : 0,
            'token'        => Str::random(30),
        ]);

        /* Attach to the study if invited */
        if ($invitation) {
            $invitation->study->users()->attach($user);

            UserJoinedAStudyJob::dispatch($user, $invitation->study);
            $invitation->delete();
        }

        return [
            'user' => $user,
        ];
    }
}

<?php


namespace App\Services;
use App\Classes\Contracts\Services\UsersService as UsersServiceContract;
use App\Models\User;

class UsersService implements UsersServiceContract
{
    /**
     * @return array
     */
    public function list(): array
    {
        return [
            'success' => true,
            'data' => User::with('studies')->get()
        ];
    }
}

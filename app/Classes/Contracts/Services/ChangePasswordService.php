<?php


namespace App\Classes\Contracts\Services;


use App\Http\Requests\User\ChangePasswordRequest;

interface ChangePasswordService
{
    /**
     * @param ChangePasswordRequest $request
     * @return array
     */
    public function changePassword(ChangePasswordRequest $request): array;
}

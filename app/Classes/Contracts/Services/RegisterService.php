<?php


namespace App\Classes\Contracts\Services;

use Illuminate\Http\Request;

interface RegisterService
{
    /**
     * Register a user
     *
     * @param Request $request
     *
     * @return array
     */
    public function register(Request $request): array;
}

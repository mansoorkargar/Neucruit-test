<?php

namespace App\Http\Controllers;

use App\Classes\Contracts\Services\UsersService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @var UsersService
     */
    private $users;

    /**
     * StudyController constructor.
     * @param UsersService $users
     */
    public function __construct(UsersService $users)
    {
        $this->users = $users;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function list(Request $request): array
    {
        return $this->users->list();
    }
}

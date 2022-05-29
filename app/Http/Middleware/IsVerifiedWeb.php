<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pktharindu\NovaPermissions\Role;

class IsVerifiedWeb
{
    /**
     * @var
     */
    public $newUser;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $path = $request->route()->parameter('path');

        if (Auth::user()) {
            $this->newUser = User::query()
                ->where('id', Auth::user()->id)
                ->whereHas('role', function ($roleRel) {
                    $roleRel->where('name', 'newuser');
                })
                ->first();
        }

        if ($this->newUser && $path != 'registration') {
            return redirect('/registration')->with('error', __('auth.denied'));
        } else {
            return $next($request);
        }
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $newUser = User::query()->where('id', Auth::user()->id)->whereHas('role', function ($roleRel) {
            $roleRel->where('name', 'newuser');
        })->first();

        if ($newUser) {
            return response()->json([
                'success' => false,
                'message' => __('auth.newuser')
            ]);
        } else {
            return $next($request);
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;


class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ... $roles): Response|RedirectResponse
    {
        if (!Auth::check()){
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Forbidden');
        } 

        return $next($request);
    }
} 
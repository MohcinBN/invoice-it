<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Constants\Role;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authUser = Auth::user();

        if ($authUser->role !== Role::SUPER_ADMIN) {
            abort(403);
        }
        
        return $next($request);
    }
}
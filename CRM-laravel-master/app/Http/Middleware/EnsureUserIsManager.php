<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\UserRolesEnum;

class EnsureUserIsManager
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || auth()->user()->role !== "Manager") {
            abort(403, 'Only managers can perform this action.');
        }

        return $next($request);
    }
}
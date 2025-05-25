<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Enums\UserRolesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $userRole = Auth::user()->role_id;
                
                if ($userRole == UserRolesEnum::Manager->value || 
                    $userRole == UserRolesEnum::Staff->value) {
                    return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
                }
                
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}

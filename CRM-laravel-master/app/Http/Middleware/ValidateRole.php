<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRolesEnum;

class ValidateRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }
        // Get role_id from authenticated user
        $userRoleId = auth()->user()->role_id;

        // Convert role names to role IDs
        $allowedRoleIds = [];
        foreach ($roles as $roleName) {
            switch ($roleName) {
                case 'Manager':
                    $allowedRoleIds[] = UserRolesEnum::Manager->value;
                    break;
                case 'Staff':
                    $allowedRoleIds[] = UserRolesEnum::Staff->value;
                    break;
                case 'Customer':
                    $allowedRoleIds[] = UserRolesEnum::Customer->value;
            }
        }

        if (!in_array($userRoleId, $allowedRoleIds)) {
            return redirect()->route('dashboard')
            ->with('error','You are not authorized to access this area.');
        }
        
        return $next($request);
    }
}

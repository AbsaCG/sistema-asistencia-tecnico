<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión');
        }

        $user = auth()->user();

        if (!$user->role) {
            abort(403, 'Usuario sin rol asignado. Contacte al administrador.');
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            // Support for permissions (perm:permission_name)
            if (str_starts_with($role, 'perm:')) {
                $perm = substr($role, 5);
                if ($user->hasPermission($perm)) {
                    return $next($request);
                }
            } 
            // Check by role name or slug using hasRole method
            else {
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
        }

        // If no roles matched, deny access
        abort(403, 'No tiene permisos suficientes para acceder a esta sección.');
    }
}

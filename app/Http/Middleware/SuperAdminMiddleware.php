<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        abort_if(! $user, 403);

        $esSuperAdmin = $user->negocios()
            ->wherePivot('id_rol', function ($q) {
                $q->select('id')
                    ->from('roles')
                    ->where('nombre', 'super_admin');
            })
            ->exists();

        abort_if(! $esSuperAdmin, 403);

        return $next($request);
    }
}

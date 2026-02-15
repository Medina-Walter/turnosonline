<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user->nombre || !$user->apellido) {

            return redirect()
                ->route('perfil.create')
                ->with('warning', 'Completá tu perfil antes de reservar un turno.');
        }

        return $next($request);
    }
}

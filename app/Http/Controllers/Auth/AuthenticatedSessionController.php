<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // Si venía de una acción protegida (reservar turno)
        if (session()->has('url.intended')) {
            return redirect()->intended('/');
        }

        // 2Super admin del sistema
        if ($user->rol === 'super_admin') {
            return redirect()->route('admin.dashboard');
        }

        // 3Usuario con negocios (admin o empleado)
        if ($user->negocios()->exists()) {
            return redirect()->route('negocios.index');
        }

        // Cliente sin contexto → dashboard
        return redirect()->route('dashboard');
    }



    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

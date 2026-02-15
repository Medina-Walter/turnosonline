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

        // Si venía de una acción protegida
        if (session()->has('url.intended')) {
            return redirect()->intended('/');
        }

        // 👑 SUPER ADMIN
        if ($user->esSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        // 👔 Usuario con negocios
        if ($user->negocios()->exists()) {
            return redirect()->route('negocios.index');
        }

        // Cliente simple
        return redirect()->route('cliente.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Plan;
use App\Models\Suscripcion;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Usuario::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 👉 PLAN GRATIS AUTOMÁTICO
        $planGratis = Plan::where('slug', 'gratis')->first();

        if ($planGratis) {
            $user->suscripcion()->create([
                'id_plan' => $planGratis->id,
                'inicia_en' => now(),
                'vence_en' => now()->addMonth(),
                'estado' => 'activa',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('cliente.index');
    }
}

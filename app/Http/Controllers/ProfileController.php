<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('perfil.index');
    }

    public function create(): View
    {
        return view('perfil.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
        ]);

        $usuario = Auth::user();
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->save();

        $redirect = session('redirect_to');

        session()->forget('redirect_to');

        return $redirect ? redirect($redirect) : redirect()->route('turnos.create')->with('success', 'Perfil actualizado correctamente.');
    }



    /**
     * Muestra el formulario de edición del perfil.
     */
    public function edit(Request $request): View
    {
        return view('perfil.edit', [
            'usuario' => $request->user(),
        ]);
    }

    /**
     * Actualiza el perfil completo del usuario.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->save();

        $redirect = session('redirect_to');

        session()->forget('redirect_to');

        return $redirect
            ? redirect($redirect)->with('success', 'Perfil actualizado correctamente.')
            : redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente.');
    }


    /**
     * Elimina la cuenta del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

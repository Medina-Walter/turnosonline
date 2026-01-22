<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request, UsuarioService $service)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $service->crear($request->all());

        return redirect()->route('login')->with('success', 'Usuario creado correctamente');
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario, UsuarioService $service)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email',
        ]);

        $service->actualizar($usuario, $request->all());

        return back()->with('success', 'Datos actualizados');
    }

    public function crearSuperadmin()
    {
        $email = 'superadmin@gmail.com';

        if (Usuario::where('email', $email)->exists()) {
            return "El usuario superadmin ya existe.";
        }

        $superadmin = Usuario::create([
            'nombre' => 'Super',
            'apellido' => 'Admin',
            'email' => $email,
            'password' => Hash::make('superadmin123'),
            'rol' => 'super_admin',
        ]);

        return "Superadmin creado correctamente con email: $email y contraseña: superadmin123";
    }
}

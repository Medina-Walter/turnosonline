<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Exception;

class UsuarioService
{
    public function crear(array $data): Usuario
    {
        if (Usuario::where('email', $data['email'])->exists()) {
            throw new Exception('El email ya está registrado');
        }

        return Usuario::create([
            'nombre'   => $data['nombre'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function actualizar(Usuario $usuario, array $data): Usuario
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $usuario->update($data);

        return $usuario;
    }
}

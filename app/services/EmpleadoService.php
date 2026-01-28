<?php

namespace App\Services;

use App\Models\Negocio;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmpleadoService
{
    public function crearEmpleadoParaNegocio(
        Negocio $negocio,
        array $data
    ): Usuario {
        return DB::transaction(function () use ($negocio, $data) {

            // Obtener rol empleado (FK real)
            $rolEmpleado = Rol::where('nombre', 'empleado')->firstOrFail();

            // Crear o reutilizar usuario
            $usuario = Usuario::firstOrCreate(
                ['email' => $data['email']],
                [
                    'nombre'   => $data['nombre'],
                    'apellido' => $data['apellido'],
                    'password' => Hash::make($data['password']),
                    'estado'   => 'activo',
                ]
            );

            // Asociar correctamente al negocio
            $negocio->usuarios()->syncWithoutDetaching([
                $usuario->id => [
                    'id_rol' => $rolEmpleado->id, // ✅ INTEGER
                ]
            ]);

            return $usuario;
        });
    }

    public function actualizarEmpleadoEnNegocio(
        Negocio $negocio,
        Usuario $usuario,
        array $data
    ): void {

        DB::transaction(function () use ($negocio, $usuario, $data) {

            $usuario->update([
                'nombre'   => $data['nombre'],
                'apellido' => $data['apellido'],
                'estado'   => $data['estado'] ?? $usuario->estado,
            ]);

            $negocio->usuarios()->updateExistingPivot(
                $usuario->id,
                ['id_rol' => $data['id_rol']]
            );
        });
    }


    public function quitarEmpleadoDelNegocio(
        Negocio $negocio,
        Usuario $usuario
    ): void {
        $negocio->usuarios()->detach($usuario->id);
    }
}

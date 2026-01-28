<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Negocio;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = Usuario::firstOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'nombre' => 'Super',
                'apellido' => 'Admin',
                'password' => Hash::make('password'),
                'estado' => 'activo',
            ]
        );

        $rol = Rol::where('nombre', 'super_admin')->firstOrFail();

        $negocioSistema = Negocio::where('slug', 'sistema')->firstOrFail();

        $usuario->negocios()->syncWithoutDetaching([
            $negocioSistema->id => [
                'id_rol' => $rol->id,
            ]
        ]);
    }
}

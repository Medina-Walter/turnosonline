<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Negocio;

class SistemaSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Crear rol super_admin
        $rol = Rol::firstOrCreate([
            'nombre' => 'super_admin'
        ]);

        // 2️⃣ Crear usuario super admin
        $usuario = Usuario::firstOrCreate(
            ['email' => 'waltermedina1357@gmail.com'],
            [
                'nombre'   => 'Walter',
                'apellido' => 'Medina',
                'password' => bcrypt('Clavelarga'),
                'estado'   => 'activo',
            ]
        );

        // 3️⃣ Crear negocio sistema
        $negocioSistema = Negocio::firstOrCreate(
            ['slug' => 'sistema'],
            [
                'nombre'     => 'Sistema',
                'es_sistema' => true,
                'estado'     => 'activo',
                'id_usuario' => $usuario->id,
            ]
        );

        // 4️⃣ Asociarlo por pivote también
        $usuario->negocios()->syncWithoutDetaching([
            $negocioSistema->id => [
                'id_rol' => $rol->id
            ]
        ]);
    }
}

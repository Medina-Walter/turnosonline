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
        Usuario::updateOrCreate(
            ['email' => 'waltermedina1357@gmail.com'],
            [
                'nombre' => 'Walter',
                'apellido' => 'Medina',
                'password' => Hash::make('ClaveLarga'),
                'estado' => 'activo',
                'is_superadmin' => true,
            ]
        );
    }
}

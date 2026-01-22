<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        Rol::firstOrCreate(['nombre' => 'super_admin']);
        Rol::firstOrCreate(['nombre' => 'admin']);
        Rol::firstOrCreate(['nombre' => 'empleado']);
        Rol::firstOrCreate(['nombre' => 'cliente']);
    }
}

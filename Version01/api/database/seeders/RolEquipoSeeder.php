<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolEquipoSeeder extends Seeder
{
    public function run(): void
    {
        // Valores según migración: ADMIN, COLABORADOR
        DB::table('rol_equipo')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'ADMIN'],
            ['id' => 2, 'nombre' => 'COLABORADOR'],
        ]);
    }
}

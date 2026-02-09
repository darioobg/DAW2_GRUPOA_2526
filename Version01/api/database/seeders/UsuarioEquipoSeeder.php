<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioEquipoSeeder extends Seeder
{
    public function run(): void
    {
        // Asignar Usuario 1 a Equipo 1 como ADMIN
        DB::table('usuario_equipo')->insertOrIgnore([
            'id_usuario' => 1,
            'id_equipo' => 1,
            'id_rol_equipo' => 1, // ADMIN
            'fecha_alta' => now(),
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

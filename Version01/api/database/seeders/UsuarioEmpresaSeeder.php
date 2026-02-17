<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioEmpresaSeeder extends Seeder
{
    public function run(): void
    {
        // Asignar Usuario 1 a Empresa 1 como OWNER
        DB::table('usuario_empresa')->insertOrIgnore([
            'id_usuario' => 1,
            'id_empresa' => 1,
            'id_rol_empresa' => 1, // OWNER
            'fecha_alta' => now(),
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

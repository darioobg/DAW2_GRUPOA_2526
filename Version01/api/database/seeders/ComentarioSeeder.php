<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        // Crea un comentario en la Tarea 1 por el Usuario 1
        DB::table('comentario')->insertOrIgnore([
            'id_tarea' => 1,
            'id_usuario' => 1,
            'texto' => 'Iniciando el desarrollo de esta tarea.',
            'fecha_creacion' => now(),
            'fecha_edicion' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

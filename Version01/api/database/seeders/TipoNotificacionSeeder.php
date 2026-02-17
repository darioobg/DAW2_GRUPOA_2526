<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoNotificacionSeeder extends Seeder
{
    public function run(): void
    {
        // Valores según migración: ASIGNACION, CAMBIO_ESTADO, COMENTARIO
        DB::table('tipo_notificacion')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'ASIGNACION'],
            ['id' => 2, 'nombre' => 'CAMBIO_ESTADO'],
            ['id' => 3, 'nombre' => 'COMENTARIO'],
        ]);
    }
}

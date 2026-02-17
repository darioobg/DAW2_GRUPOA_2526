<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notificacion')->insertOrIgnore([
            'id_tarea' => 1,
            'id_usuario_destino' => 1,
            'id_tipo_notificacion' => 1, // ASIGNACION
            'id_canal_notificacion' => 2, // INAPP
            'mensaje' => 'Se te ha asignado la tarea: Diseño de BD',
            'leida' => false,
            'fecha_envio' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

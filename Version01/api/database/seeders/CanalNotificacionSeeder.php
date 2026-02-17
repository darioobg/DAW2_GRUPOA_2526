<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CanalNotificacionSeeder extends Seeder
{
    public function run(): void
    {
        // Valores según migración: EMAIL, INAPP
        DB::table('canal_notificacion')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'EMAIL'],
            ['id' => 2, 'nombre' => 'INAPP'],
        ]);
    }
}

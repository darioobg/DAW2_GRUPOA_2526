<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('estado_proyecto')->insert([
            [
                'nombre' => 'Activo',
                'estado' => 'activo',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre' => 'Archivado',
                'estado' => 'archivado',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prioridad')->insert([
            ['nombre' => 'baja', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'media', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'alta', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

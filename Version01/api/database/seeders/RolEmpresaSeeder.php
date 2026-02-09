<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Valores según migración: OWNER, ADMIN, MIEMBRO
        DB::table('rol_empresa')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'OWNER'],
            ['id' => 2, 'nombre' => 'ADMIN'],
            ['id' => 3, 'nombre' => 'MIEMBRO'],
        ]);
    }
    }


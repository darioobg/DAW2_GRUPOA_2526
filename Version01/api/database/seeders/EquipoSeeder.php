<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos de prueba para la tabla 'equipo' usando solo los campos definidos en la migración
        DB::table('equipo')->insert([
            [
                'id_empresa' => 1,
                'nombre' => 'Desarrollo Backend',
                'descripcion' => 'Equipo encargado del desarrollo, mantenimiento y revisión de APIs y servicios internos.',
                'fecha_creacion' => '2024-04-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_empresa' => 1,
                'nombre' => 'Equipo de Diseño UX/UI',
                'descripcion' => 'Responsables del diseño de experiencia de usuario y las interfaces visuales de las aplicaciones.',
                'fecha_creacion' => '2024-04-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_empresa' => 2,
                'nombre' => 'Infraestructura y DevOps',
                'descripcion' => 'Gestionan la infraestructura en la nube, CI/CD y el soporte de sistemas.',
                'fecha_creacion' => '2024-05-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

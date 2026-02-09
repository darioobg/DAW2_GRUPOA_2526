<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        // Datos de prueba para la tabla 'proyectos'
        DB::table('proyectos')->insert([
            [
                'id_equipo' => 1,
                'nombre' => 'Sistema de Gestión Académica',
                'descripcion' => 'Proyecto para gestionar inscripciones, calificaciones y asistencia de alumnos.',
                'fecha_creacion' => '2024-06-01',
                'fecha_inicio' => '2024-06-05',
                'fecha_fin_prevista' => '2024-08-30',
                'id_estado_proyecto' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_equipo' => 2,
                'nombre' => 'Plataforma de Comercio Electrónico',
                'descripcion' => 'Proyecto para desarrollar una plataforma de ventas online con pagos integrados.',
                'fecha_creacion' => '2024-05-20',
                'fecha_inicio' => '2024-05-25',
                'fecha_fin_prevista' => '2024-08-01',
                'id_estado_proyecto' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_equipo' => 1,
                'nombre' => 'App de Control de Inventarios',
                'descripcion' => 'Aplicación móvil y web para controlar inventarios en tiempo real.',
                'fecha_creacion' => '2024-06-10',
                'fecha_inicio' => '2024-06-12',
                'fecha_fin_prevista' => '2024-09-30',
                'id_estado_proyecto' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_equipo' => 3,
                'nombre' => 'Portal de Recursos Humanos',
                'descripcion' => 'Portal para gestión de nóminas, contrataciones y evaluaciones de personal.',
                'fecha_creacion' => '2024-06-15',
                'fecha_inicio' => '2024-06-20',
                'fecha_fin_prevista' => '2024-10-28',
                'id_estado_proyecto' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_equipo' => 2,
                'nombre' => 'Sistema de Reservas Médicas',
                'descripcion' => 'Plataforma para que pacientes reserven citas médicas en línea.',
                'fecha_creacion' => '2024-07-01',
                'fecha_inicio' => '2024-07-03',
                'fecha_fin_prevista' => '2024-11-15',
                'id_estado_proyecto' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

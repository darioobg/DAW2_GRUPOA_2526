<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos de prueba para la tabla 'tarea' usando los campos de la migración
        DB::table('tarea')->insert([
            [
                'id_proyectos' => 1,
                'id_prioridad' => 2,
                'id_asignado_a' => 1,
                'id_estado' => 1,
                'titulo' => 'Implementar Login',
                'descripcion' => 'Crear la funcionalidad de inicio de sesión de usuarios.',
                'fecha_creacion' => '2024-06-10',
                'fecha_limite' => '2024-06-12',
                'fecha_cierre' => null,
                'orden_kanban' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_proyectos' => 1,
                'id_prioridad' => 3,
                'id_asignado_a' => 2,
                'id_estado' => 2,
                'titulo' => 'Diseñar base de datos',
                'descripcion' => 'Modelar y crear las tablas principales de la base de datos.',
                'fecha_creacion' => '2024-06-11',
                'fecha_limite' => '2024-06-16',
                'fecha_cierre' => null,
                'orden_kanban' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_proyectos' => 1,
                'id_prioridad' => 1,
                'id_asignado_a' => 3,
                'id_estado' => 3,
                'titulo' => 'Actualizar documentación',
                'descripcion' => 'Revisar y actualizar el README del proyecto.',
                'fecha_creacion' => '2024-06-01',
                'fecha_limite' => '2024-06-02',
                'fecha_cierre' => '2024-06-03',
                'orden_kanban' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_proyectos' => 1,
                'id_prioridad' => 2,
                'id_asignado_a' => 1,
                'id_estado' => 4,
                'titulo' => 'Preparar entorno de pruebas',
                'descripcion' => 'Configurar entorno de testing y pruebas automatizadas.',
                'fecha_creacion' => '2024-06-15',
                'fecha_limite' => '2024-06-18',
                'fecha_cierre' => null,
                'orden_kanban' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

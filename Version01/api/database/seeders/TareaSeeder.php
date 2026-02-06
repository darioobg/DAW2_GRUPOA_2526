<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarea;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asume que los campos del modelo Tarea son: id, nombre, descripcion, estado, proyecto_id, usuario_id, fecha_inicio, fecha_fin_prevista
        Tarea::insert([
            [
                'id' => 1,
                'nombre' => 'Tarea de Prueba 1',
                'descripcion' => 'Descripción de la Tarea 1',
                'estado' => 'pendiente',
                'proyecto_id' => 1,
                'usuario_id' => 1,
                'fecha_inicio' => '2024-06-01',
                'fecha_fin_prevista' => '2024-06-02',
            ],
            [
                'id' => 1,
                'nombre' => 'Tarea de Prueba 2',
                'descripcion' => 'Descripción de la Tarea 2',
                'estado' => 'en_progreso',
                'proyecto_id' => 1,
                'usuario_id' => 1,
                'fecha_inicio' => '2024-06-03',
                'fecha_fin_prevista' => '2024-06-04',
            ],
            [
                'id' => 1,
                'nombre' => 'Tarea de Prueba 3',
                'descripcion' => 'Descripción de la Tarea 3',
                'estado' => 'completada',
                'proyecto_id' => 1,
                'usuario_id' => 1,
                'fecha_inicio' => '2024-06-05',
                'fecha_fin_prevista' => '2024-06-06',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\EstadoTarea;
use App\Models\Proyecto;
use Illuminate\Database\Seeder;

class EstadoTareaSeeder extends Seeder
{
    public function run(): void
    {
        $proyectos = Proyecto::all();

        foreach ($proyectos as $proyecto) {
            // ⚠️ Evitar duplicados si el seeder corre más de una vez
            if ($proyecto->estadoTareas()->count() > 0) {
                continue;
            }

            EstadoTarea::insert([
                [
                    'nombre' => 'Pendiente',
                    'orden' => 1,
                    'id_proyecto' => $proyecto->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nombre' => 'En Progreso',
                    'orden' => 2,
                    'id_proyecto' => $proyecto->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nombre' => 'Finalizado',
                    'orden' => 3,
                    'id_proyecto' => $proyecto->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}

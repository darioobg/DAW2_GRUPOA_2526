<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\EstadoProyecto;
use App\Models\Proyecto;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener equipos existentes
        $equipo1 = Equipo::where('nombre', 'Desarrollo Backend')->first();
        $equipo2 = Equipo::where('nombre', 'Equipo de Diseño UX/UI')->first();

        // Obtener estados de proyecto por nombre
        $estadoPlanificacion = EstadoProyecto::where('nombre', 'Planificación')->first();
        $estadoEnDesarrollo = EstadoProyecto::where('nombre', 'En Desarrollo')->first();

        // Registro 1
        Proyecto::create([
            'id_equipo' => optional($equipo1)->id,
            'nombre' => 'Portal de Soporte al Cliente',
            'descripcion' => 'Desarrollo de una plataforma en línea para gestionar consultas y tickets de soporte técnico.',
            'fecha_creacion' => Carbon::parse('2024-05-10 09:00:00'),
            'fecha_inicio' => Carbon::parse('2024-05-12 09:00:00'),
            'fecha_fin_prevista' => Carbon::parse('2024-07-01 17:00:00'),
            'id_estado_proyecto' => 1,
        ]);

        // Registro 2
        Proyecto::create([
            'id_equipo' => optional($equipo2)->id,
            'nombre' => 'Integración de Pasarela de Pago',
            'descripcion' => 'Implementación y pruebas de una nueva pasarela de pago para el sitio e-commerce.',
            'fecha_creacion' => Carbon::parse('2024-05-15 10:30:00'),
            'fecha_inicio' => Carbon::parse('2024-05-16 10:30:00'),
            'fecha_fin_prevista' => Carbon::parse('2024-06-16 18:00:00'),
            'id_estado_proyecto' => 1,
        ]);

        // Registro 3
        Proyecto::create([
            'id_equipo' => optional($equipo1)->id,
            'nombre' => 'Actualización de Política de Privacidad',
            'descripcion' => 'Revisión y actualización de las políticas de privacidad y manejo de datos del sistema.',
            'fecha_creacion' => Carbon::parse('2024-05-20 08:45:00'),
            'fecha_inicio' => Carbon::parse('2024-05-22 08:45:00'),
            'fecha_fin_prevista' => Carbon::parse('2024-06-05 17:00:00'),
            'id_estado_proyecto' => 1,
        ]);
    }
}

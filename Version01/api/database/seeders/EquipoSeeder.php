<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Equipo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresa = Empresa::first();

        if (!$empresa) {
            // Optionally throw an exception or log something here
            return;
        }

        $equipos = [
            [
                'nombre' => 'Desarrollo Backend',
                'descripcion' => 'El equipo encargado del desarrollo, mantenimiento y revisión de APIs y servicios internos del sistema.',
                'fecha_creacion' => Carbon::parse('2024-04-15 10:00:00'),
            ],
            [
                'nombre' => 'Equipo de Diseño UX/UI',
                'descripcion' => 'Responsables del diseño de experiencia de usuario y las interfaces visuales de las aplicaciones.',
                'fecha_creacion' => Carbon::parse('2024-04-20 09:30:00'),
            ]
        ];

        foreach ($equipos as $equipo) {
            Equipo::create([
                'id_empresa' => $empresa->id,
                'nombre' => $equipo['nombre'],
                'descripcion' => $equipo['descripcion'],
                'fecha_creacion' => $equipo['fecha_creacion'],
            ]);
        }
    }
}

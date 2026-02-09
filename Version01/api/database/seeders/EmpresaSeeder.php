<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::create([
            'nombre' => 'Tech Solutions S.A.',
            'cif_nif' => 'B12345678',
            'direccion' => 'Avenida de la Innovación, 100, 28050 Madrid, España',
            'telefono' => '+34 915 555 123',
            'fecha_alta' => Carbon::parse('2023-09-01'),
            'activa' => true,
        ]);

        Empresa::create([
            'nombre' => 'Grupo Innovatec S.L.',
            'cif_nif' => 'B87654321',
            'direccion' => 'Calle Tecnología, 22, 46020 Valencia, España',
            'telefono' => '+34 963 456 789',
            'fecha_alta' => Carbon::parse('2024-01-15'),
            'activa' => true,
        ]);

        Empresa::create([
            'nombre' => 'Servicios Digitales Europa',
            'cif_nif' => 'A11223344',
            'direccion' => 'Paseo de las Ciencias, 10, 08030 Barcelona, España',
            'telefono' => '+34 934 765 432',
            'fecha_alta' => Carbon::parse('2022-07-20'),
            'activa' => false,
        ]);
    }
}

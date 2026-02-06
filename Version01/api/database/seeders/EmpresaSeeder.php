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
            'fecha_alta' => Carbon::parse('2023-09-01 09:15:00'),
            'activa' => true,
        ]);
    }
}

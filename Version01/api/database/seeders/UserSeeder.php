<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'jolivera',
                'apellidos' => 'Pérez García',
                'email' => 'juan.perez@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('uw872301'),
                'fecha_registro' => '2022-05-01',
                'ultimoAcceso' => $now->format('Y-m-d'),
                'activo' => true,
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Laura',
                'apellidos' => 'Martínez López',
                'email' => 'laura.martinez@example.com',
                'email_verified_at' => null,
                'password' => Hash::make('lar123456'),
                'fecha_registro' => '2023-01-15',
                'ultimoAcceso' => $now->copy()->subDay()->format('Y-m-d'),
                'activo' => true,
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Carlos',
                'apellidos' => 'Sánchez Ruiz',
                'email' => 'carlos.sanchez@example.com',
                'email_verified_at' => '2023-08-20 11:15:00',
                'password' => Hash::make('carlospass'),
                'fecha_registro' => '2023-08-20',
                'ultimoAcceso' => $now->copy()->subDays(7)->format('Y-m-d'),
                'activo' => false,
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

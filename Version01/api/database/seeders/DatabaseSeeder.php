<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CATÁLOGOS (Sin dependencias)
        $this->call([
            PrioridadSeeder::class,
            EstadoTareaSeeder::class,
            EstadoProyectoSeeder::class,
            RolEmpresaSeeder::class,        // Nuevo
            RolEquipoSeeder::class,         // Nuevo
            TipoNotificacionSeeder::class,  // Nuevo
            CanalNotificacionSeeder::class, // Nuevo
        ]);

        // 2. ENTIDADES PRINCIPALES (Crean los IDs 1)
        $this->call([
            UserSeeder::class,     // Crea usuarios
            EmpresaSeeder::class,  // Crea empresas
        ]);

        // 3. DEPENDIENTES DE NIVEL 1
        $this->call([
            EquipoSeeder::class,         // Depende de Empresa
            UsuarioEmpresaSeeder::class, // Nuevo (Depende de User, Empresa, Rol)
        ]);

        // 4. DEPENDIENTES DE NIVEL 2
        $this->call([
            ProyectoSeeder::class,       // Depende de Equipo
            UsuarioEquipoSeeder::class,  // Nuevo (Depende de User, Equipo, Rol)
        ]);

        // 5. DEPENDIENTES DE NIVEL 3 (Tareas y transaccionales)
        $this->call([
            TareaSeeder::class,          // Depende de Proyecto, User, Estados
            ComentarioSeeder::class,     // Nuevo (Depende de Tarea, User)
            NotificacionSeeder::class,   // Nuevo (Depende de Tarea, User, Tipos)
        ]);
    }
}

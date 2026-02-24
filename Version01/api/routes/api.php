<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// --- 1. Controladores de Autenticación (Carpeta Api) ---
use App\Http\Controllers\Api\AuthController;
// --- 2. Controladores de Entidades (Carpeta base Controllers) ---
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuarioController;
// --- 3. Controladores de Catálogos ---
use App\Http\Controllers\CanalNotificacionController;
use App\Http\Controllers\EstadoProyectoController;
use App\Http\Controllers\EstadoTareaController;
use App\Http\Controllers\PrioridadController;
use App\Http\Controllers\RolEmpresaController;
use App\Http\Controllers\RolEquipoController;
use App\Http\Controllers\TipoNotificacionController;
// --- 4. Controladores de Pivotes ---
use App\Http\Controllers\UsuarioEmpresaController;
use App\Http\Controllers\UsuarioEquipoController;

Route::prefix('v1')->group(function () {
    Route::get('test', function () {
        throw new \Exception('TEST API');
    });

    Route::get('health', function () {
        return response()->json([
            'status' => 'ok'
        ]);
    });
    // ==========================================
    //            RUTAS PÚBLICAS
    // ==========================================

    // Login para obtener el token
    Route::post('/login', [AuthController::class, 'login']);
    // ==========================================

    Route::middleware('auth:sanctum')->group(function () {
        // --- Gestión de Sesión ---
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');;

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        //            RUTAS PROTEGIDAS
        //    (Requieren Header -> Authorization: Bearer <token>)
        // ==========================================
        Route::get('/mis-equipos', [EquipoController::class, 'misEquipos']);
        Route::get('/mis-proyectos', [ProyectoController::class, 'misProyectos']);
        Route::apiResource('proyectos', ProyectoController::class);
        Route::prefix('proyectos/{idProyecto}')->group(function () {
            Route::get('/columnas', [EstadoTareaController::class, 'index']);
            Route::post('/columnas', [EstadoTareaController::class, 'store']);
        });

        Route::put('/columnas/{id}', [EstadoTareaController::class, 'update']);
        Route::delete('/columnas/{id}', [EstadoTareaController::class, 'destroy']);

        // --- Entidades Principales (CRUD Automático) ---
        Route::get('/mis-tareas', [TareaController::class, 'misTareas']);
        Route::apiResource('tareas', TareaController::class);
        Route::patch('/tareas/{id}/mover', [TareaController::class, 'mover']);

        Route::apiResource('comentarios', ComentarioController::class);
        Route::apiResource('notificaciones', NotificacionController::class);
        Route::apiResource('usuarios', UsuarioController::class);
        Route::apiResource('empresas', EmpresaController::class);
        Route::apiResource('equipos', EquipoController::class);

        // --- Catálogos / Tablas Auxiliares ---
        Route::apiResource('prioridades', PrioridadController::class);
        Route::apiResource('estado-proyecto', EstadoProyectoController::class);
        Route::apiResource('roles-empresa', RolEmpresaController::class);
        Route::apiResource('roles-equipo', RolEquipoController::class);
        Route::apiResource('tipos-notificacion', TipoNotificacionController::class);
        Route::apiResource('canales-notificacion', CanalNotificacionController::class);

        // --- Tablas Pivote (Rutas Manuales por doble ID) ---

        // Usuarios en Equipos
        Route::get('usuarios-equipo', [UsuarioEquipoController::class, 'index']);
        Route::post('usuarios-equipo', [UsuarioEquipoController::class, 'store']);
        Route::get('usuarios-equipo/{id_usuario}/{id_equipo}', [UsuarioEquipoController::class, 'show']);
        Route::put('usuarios-equipo/{id_usuario}/{id_equipo}', [UsuarioEquipoController::class, 'update']);
        Route::delete('usuarios-equipo/{id_usuario}/{id_equipo}', [UsuarioEquipoController::class, 'destroy']);
        // Usuarios en Empresas
        Route::get('usuarios-empresa', [UsuarioEmpresaController::class, 'index']);
        Route::post('usuarios-empresa', [UsuarioEmpresaController::class, 'store']);
        // Nota: Revisa si tu controlador espera 1 ID o 2 IDs para show/update/delete.
        // Aquí asumo 1 ID (id de la relación) basado en tu código anterior,
        // si usas composite keys como en equipo, cámbialo al formato /{id_usuario}/{id_empresa}
        Route::get('usuarios-empresa/{id}', [UsuarioEmpresaController::class, 'show']);
        Route::put('usuarios-empresa/{id}', [UsuarioEmpresaController::class, 'update']);
        Route::delete('usuarios-empresa/{id}', [UsuarioEmpresaController::class, 'destroy']);
    });
});

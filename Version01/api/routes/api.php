<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\CanalNotificacionController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstadoProyectoController;
use App\Http\Controllers\EstadoTareaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\PrioridadController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RolEmpresaController;
use App\Http\Controllers\RolEquipoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\TipoNotificacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioEmpresaController;
use App\Http\Controllers\UsuarioEquipoController;

Route::prefix('v1')->group(function () {

    // --- ENTIDADES PRINCIPALES (CRUD ESTÁNDAR) ---
    // apiResource genera automáticamente: index (GET), store (POST), show (GET), update (PUT/PATCH), destroy (DELETE)

    Route::apiResource('proyectos', ProyectoController::class);
    Route::apiResource('tareas', TareaController::class);
    Route::apiResource('comentarios', ComentarioController::class);
    Route::apiResource('notificaciones', NotificacionController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('empresas', EmpresaController::class);
    Route::apiResource('equipos', EquipoController::class);

    // --- CATÁLOGOS / AUXILIARES ---

    Route::apiResource('prioridades', PrioridadController::class);
    Route::apiResource('estado-tarea', EstadoTareaController::class);
    Route::apiResource('estado-proyecto', EstadoProyectoController::class);
    Route::apiResource('roles-empresa', RolEmpresaController::class);
    Route::apiResource('roles-equipo', RolEquipoController::class);
    Route::apiResource('tipos-notificacion', TipoNotificacionController::class);
    Route::apiResource('canales-notificacion', CanalNotificacionController::class);

    // --- TABLAS PIVOTE (Relaciones Muchos a Muchos) ---
    // Estas se mantienen manuales porque requieren dos IDs en la URL (Composite Keys)

    // USUARIO_EQUIPO
    Route::get('usuarios-equipo', [UsuarioEquipoController::class, 'index']);
    Route::post('usuarios-equipo', [UsuarioEquipoController::class, 'store']);
    Route::get('usuarios-equipo/{id_usuario}/{id_equipo}', [UsuarioEquipoController::class, 'show']);
    Route::put('usuarios-equipo/{id_usuario}/{id_equipo}', [UsuarioEquipoController::class, 'update']);
    Route::patch('usuarios-equipo/{id_usuario}/{id_equipo}', [UsuarioEquipoController::class, 'update']);
    Route::delete('usuarios-equipo/{id_usuario}/{id_equipo}', [UsuarioEquipoController::class, 'destroy']);

    // USUARIO_EMPRESA
    Route::get('usuarios-empresa', [UsuarioEmpresaController::class, 'index']);
    Route::post('usuarios-empresa', [UsuarioEmpresaController::class, 'store']);
    Route::get('usuarios-empresa/{id_usuario}/{id_empresa}', [UsuarioEmpresaController::class, 'show']); 
    Route::put('usuarios-empresa/{id_usuario}/{id_empresa}', [UsuarioEmpresaController::class, 'update']);
    Route::patch('usuarios-empresa/{id_usuario}/{id_empresa}', [UsuarioEmpresaController::class, 'update']);
    Route::delete('usuarios-empresa/{id_usuario}/{id_empresa}', [UsuarioEmpresaController::class, 'destroy']);
});

<?php
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\ProyectoController;
use App\Http\Controllers\Api\TareaController;
use App\Http\Controllers\Api\ComentarioController;
use App\Http\Controllers\Api\NotificacionController;

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\EquipoController;

use App\Http\Controllers\Api\PrioridadController;
use App\Http\Controllers\Api\EstadoTareaController;
use App\Http\Controllers\Api\EstadoProyectoController;

use App\Http\Controllers\Api\RolEmpresaController;
use App\Http\Controllers\Api\RolEquipoController;

use App\Http\Controllers\Api\TipoNotificacionController;
use App\Http\Controllers\Api\CanalNotificacionController;

use App\Http\Controllers\Api\UsuarioEquipoController;
use App\Http\Controllers\Api\UsuarioEmpresaController;

Route::prefix('v1')->group(function () {

    // PROYECTO
 
    Route::get('proyectos', [ProyectoController::class, 'index']);
    Route::post('proyectos', [ProyectoController::class, 'store']);
    Route::get('proyectos/{id}', [ProyectoController::class, 'show']);
    Route::put('proyectos/{id}', [ProyectoController::class, 'update']);
    Route::patch('proyectos/{id}', [ProyectoController::class, 'update']);
    Route::delete('proyectos/{id}', [ProyectoController::class, 'destroy']);

  
    // TAREA
   
    Route::get('tareas', [TareaController::class, 'index']);
    Route::post('tareas', [TareaController::class, 'store']);
    Route::get('tareas/{id}', [TareaController::class, 'show']);
    Route::put('tareas/{id}', [TareaController::class, 'update']);
    Route::patch('tareas/{id}', [TareaController::class, 'update']);
    Route::delete('tareas/{id}', [TareaController::class, 'destroy']);

    // COMENTARIO

    Route::get('comentarios', [ComentarioController::class, 'index']);
    Route::post('comentarios', [ComentarioController::class, 'store']);
    Route::get('comentarios/{id}', [ComentarioController::class, 'show']);
    Route::put('comentarios/{id}', [ComentarioController::class, 'update']);
    Route::patch('comentarios/{id}', [ComentarioController::class, 'update']);
    Route::delete('comentarios/{id}', [ComentarioController::class, 'destroy']);

    // NOTIFICACION
    
    Route::get('notificaciones', [NotificacionController::class, 'index']);
    Route::post('notificaciones', [NotificacionController::class, 'store']);
    Route::get('notificaciones/{id}', [NotificacionController::class, 'show']);
    Route::put('notificaciones/{id}', [NotificacionController::class, 'update']);
    Route::patch('notificaciones/{id}', [NotificacionController::class, 'update']);
    Route::delete('notificaciones/{id}', [NotificacionController::class, 'destroy']);


    // USUARIO
 
    Route::get('usuarios', [UsuarioController::class, 'index']);
    Route::post('usuarios', [UsuarioController::class, 'store']);
    Route::get('usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('usuarios/{id}', [UsuarioController::class, 'update']);
    Route::patch('usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);


    // EMPRESA

    Route::get('empresas', [EmpresaController::class, 'index']);
    Route::post('empresas', [EmpresaController::class, 'store']);
    Route::get('empresas/{id}', [EmpresaController::class, 'show']);
    Route::put('empresas/{id}', [EmpresaController::class, 'update']);
    Route::patch('empresas/{id}', [EmpresaController::class, 'update']);
    Route::delete('empresas/{id}', [EmpresaController::class, 'destroy']);

    
    // EQUIPO
   
    Route::get('equipos', [EquipoController::class, 'index']);
    Route::post('equipos', [EquipoController::class, 'store']);
    Route::get('equipos/{id}', [EquipoController::class, 'show']);
    Route::put('equipos/{id}', [EquipoController::class, 'update']);
    Route::patch('equipos/{id}', [EquipoController::class, 'update']);
    Route::delete('equipos/{id}', [EquipoController::class, 'destroy']);

 
    // PRIORIDAD
   
    Route::get('prioridades', [PrioridadController::class, 'index']);
    Route::post('prioridades', [PrioridadController::class, 'store']);
    Route::get('prioridades/{id}', [PrioridadController::class, 'show']);
    Route::put('prioridades/{id}', [PrioridadController::class, 'update']);
    Route::patch('prioridades/{id}', [PrioridadController::class, 'update']);
    Route::delete('prioridades/{id}', [PrioridadController::class, 'destroy']);

   
    // ESTADO_TAREA
  
    Route::get('estado-tarea', [EstadoTareaController::class, 'index']);
    Route::post('estado-tarea', [EstadoTareaController::class, 'store']);
    Route::get('estado-tarea/{id}', [EstadoTareaController::class, 'show']);
    Route::put('estado-tarea/{id}', [EstadoTareaController::class, 'update']);
    Route::patch('estado-tarea/{id}', [EstadoTareaController::class, 'update']);
    Route::delete('estado-tarea/{id}', [EstadoTareaController::class, 'destroy']);

    // ESTADO_PROYECTO
    
    Route::get('estado-proyecto', [EstadoProyectoController::class, 'index']);
    Route::post('estado-proyecto', [EstadoProyectoController::class, 'store']);
    Route::get('estado-proyecto/{id}', [EstadoProyectoController::class, 'show']);
    Route::put('estado-proyecto/{id}', [EstadoProyectoController::class, 'update']);
    Route::patch('estado-proyecto/{id}', [EstadoProyectoController::class, 'update']);
    Route::delete('estado-proyecto/{id}', [EstadoProyectoController::class, 'destroy']);

 
    // ROL_EMPRESA
  
    Route::get('roles-empresa', [RolEmpresaController::class, 'index']);
    Route::post('roles-empresa', [RolEmpresaController::class, 'store']);
    Route::get('roles-empresa/{id}', [RolEmpresaController::class, 'show']);
    Route::put('roles-empresa/{id}', [RolEmpresaController::class, 'update']);
    Route::patch('roles-empresa/{id}', [RolEmpresaController::class, 'update']);
    Route::delete('roles-empresa/{id}', [RolEmpresaController::class, 'destroy']);

 
    // ROL_EQUIPO
  
    Route::get('roles-equipo', [RolEquipoController::class, 'index']);
    Route::post('roles-equipo', [RolEquipoController::class, 'store']);
    Route::get('roles-equipo/{id}', [RolEquipoController::class, 'show']);
    Route::put('roles-equipo/{id}', [RolEquipoController::class, 'update']);
    Route::patch('roles-equipo/{id}', [RolEquipoController::class, 'update']);
    Route::delete('roles-equipo/{id}', [RolEquipoController::class, 'destroy']);


    // TIPO_NOTIFICACION
 
    Route::get('tipos-notificacion', [TipoNotificacionController::class, 'index']);
    Route::post('tipos-notificacion', [TipoNotificacionController::class, 'store']);
    Route::get('tipos-notificacion/{id}', [TipoNotificacionController::class, 'show']);
    Route::put('tipos-notificacion/{id}', [TipoNotificacionController::class, 'update']);
    Route::patch('tipos-notificacion/{id}', [TipoNotificacionController::class, 'update']);
    Route::delete('tipos-notificacion/{id}', [TipoNotificacionController::class, 'destroy']);


    // CANAL_NOTIFICACION

    Route::get('canales-notificacion', [CanalNotificacionController::class, 'index']);
    Route::post('canales-notificacion', [CanalNotificacionController::class, 'store']);
    Route::get('canales-notificacion/{id}', [CanalNotificacionController::class, 'show']);
    Route::put('canales-notificacion/{id}', [CanalNotificacionController::class, 'update']);
    Route::patch('canales-notificacion/{id}', [CanalNotificacionController::class, 'update']);
    Route::delete('canales-notificacion/{id}', [CanalNotificacionController::class, 'destroy']);

    
    // USUARIO_EQUIPO (pivote)
  
    Route::get('usuarios-equipo', [UsuarioEquipoController::class, 'index']);
    Route::post('usuarios-equipo', [UsuarioEquipoController::class, 'store']);
    Route::get('usuarios-equipo/{id}', [UsuarioEquipoController::class, 'show']);
    Route::put('usuarios-equipo/{id}', [UsuarioEquipoController::class, 'update']);
    Route::patch('usuarios-equipo/{id}', [UsuarioEquipoController::class, 'update']);
    Route::delete('usuarios-equipo/{id}', [UsuarioEquipoController::class, 'destroy']);

   
    // USUARIO_EMPRESA (pivote)

    Route::get('usuarios-empresa', [UsuarioEmpresaController::class, 'index']);
    Route::post('usuarios-empresa', [UsuarioEmpresaController::class, 'store']);
    Route::get('usuarios-empresa/{id}', [UsuarioEmpresaController::class, 'show']);
    Route::put('usuarios-empresa/{id}', [UsuarioEmpresaController::class, 'update']);
    Route::patch('usuarios-empresa/{id}', [UsuarioEmpresaController::class, 'update']);
    Route::delete('usuarios-empresa/{id}', [UsuarioEmpresaController::class, 'destroy']);
});

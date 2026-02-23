<?php

namespace App\Repositories;

use App\Models\Tarea;
use Illuminate\Database\Eloquent\Collection;

class TareaRepository
{
    public function obtenerTodas(): Collection
    {
        return Tarea::orderBy('fecha_creacion', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Tarea
    {
        return Tarea::find($id);
    }

    public function obtenerPorUsuario(int $userId)
    {
        return Tarea::with(['estado_tarea', 'prioridad', 'proyecto'])
            ->where('id_asignado_a', $userId)
            ->orderBy('orden_kanban')
            ->get();
    }

    public function crear(array $datos): Tarea
    {
        return Tarea::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Tarea
    {
        $tarea = Tarea::find($id);
        if (!$tarea)
            return null;

        $tarea->update($datos);
        return $tarea->fresh();
    }

    public function eliminar(int $id): bool
    {
        $tarea = Tarea::find($id);
        if (!$tarea)
            return false;

        return (bool) $tarea->delete();
    }
}

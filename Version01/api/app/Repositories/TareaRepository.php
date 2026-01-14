<?php

namespace App\Repositories;

use App\Models\Tarea;
use Illuminate\Database\Eloquent\Collection;

class TareaRepository
{
    public function obtenerTodas(): Collection
    {
        return Tarea::orderBy('fecha_creación', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Tarea
    {
        return Tarea::find($id);
    }

    public function crear(array $datos): Tarea
    {
        return Tarea::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Tarea
{
    // Versión minimalista de la rama conflicto
    Tarea::where('id', $id)->update($datos);
    return Tarea::find($id);
}

    public function eliminar(int $id): bool
    {
        $tarea = Tarea::find($id);
        if (!$tarea) return false;

        return (bool) $tarea->delete();
    }
}

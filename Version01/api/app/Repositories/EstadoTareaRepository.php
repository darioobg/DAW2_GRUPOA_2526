<?php

namespace App\Repositories;

use App\Models\EstadoTarea;
use Illuminate\Database\Eloquent\Collection;

class EstadoTareaRepository
{
    public function obtenerPorProyecto(int $idProyecto)
    {
        return EstadoTarea::where('id_proyecto', $idProyecto)
            ->orderBy('orden')
            ->get();
    }

    public function obtenerPorId(int $id): ?EstadoTarea
    {
        return EstadoTarea::find($id);
    }

    public function crear(array $datos): EstadoTarea
    {
        return EstadoTarea::create($datos);
    }

    public function actualizar(int $id, array $datos): ?EstadoTarea
    {
        $estado = EstadoTarea::find($id);
        if (!$estado)
            return null;

        $estado->update($datos);
        return $estado->fresh();
    }

    public function eliminar(int $id): bool
    {
        $estado = EstadoTarea::find($id);
        if (!$estado)
            return false;

        return (bool) $estado->delete();
    }
}

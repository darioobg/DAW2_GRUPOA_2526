<?php

namespace App\Repositories;

use App\Models\EstadoProyecto;
use Illuminate\Database\Eloquent\Collection;

class EstadoProyectoRepository
{
    public function obtenerTodos(): Collection
    {
        return EstadoProyecto::orderBy('id')->get();
    }

    public function obtenerPorId(int $id): ?EstadoProyecto
    {
        return EstadoProyecto::find($id);
    }

    public function crear(array $datos): EstadoProyecto
    {
        return EstadoProyecto::create($datos);
    }

    public function actualizar(int $id, array $datos): ?EstadoProyecto
    {
        $estado = EstadoProyecto::find($id);
        if (!$estado) return null;

        $estado->update($datos);
        return $estado->fresh();
    }

    public function eliminar(int $id): bool
    {
        $estado = EstadoProyecto::find($id);
        if (!$estado) return false;

        return (bool) $estado->delete();
    }
}

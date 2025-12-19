<?php

namespace App\Repositories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Collection;

class ProyectoRepository
{
    public function obtenerTodos(): Collection
    {
        return Proyecto::orderBy('created_at', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Proyecto
    {
        return Proyecto::find($id);
    }

    public function crear(array $datos): Proyecto
    {
        return Proyecto::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Proyecto
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) return null;

        $proyecto->update($datos);
        return $proyecto->fresh();
    }

    public function eliminar(int $id): bool
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) return false;

        return (bool) $proyecto->delete();
    }
}

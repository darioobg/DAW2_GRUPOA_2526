<?php

namespace App\Repositories;

use App\Models\Prioridad;
use Illuminate\Database\Eloquent\Collection;

class PrioridadRepository
{
    public function obtenerTodos(): Collection
    {
        return Prioridad::orderBy('id')->get();
    }

    public function obtenerPorId(int $id): ?Prioridad
    {
        return Prioridad::find($id);
    }

    public function crear(array $datos): Prioridad
    {
        return Prioridad::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Prioridad
    {
        $prioridad = Prioridad::find($id);
        if (!$prioridad) return null;

        $prioridad->update($datos);
        return $prioridad->fresh();
    }

    public function eliminar(int $id): bool
    {
        $prioridad = Prioridad::find($id);
        if (!$prioridad) return false;

        return (bool) $prioridad->delete();
    }
}

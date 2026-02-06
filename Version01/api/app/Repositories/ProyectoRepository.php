<?php

namespace App\Repositories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Collection;

class ProyectoRepository
{
    /**
     * Obtiene todos los proyectos con filtros opcionales.
     *
     * @param array $filters
     * @return Collection
     */
    public function obtenerTodos(array $filters = []): Collection
    {
        $query = Proyecto::query();

        if (!empty($filters['nombre'])) {
            $query->where('nombre', 'like', '%' . $filters['nombre'] . '%');
        }

        if (!empty($filters['id_estado_proyecto'])) {
            $query->where('id_estado_proyecto', $filters['id_estado_proyecto']);
        }

        if (!empty($filters['fecha_inicio_desde'])) {
            $query->where('fecha_inicio', '>=', $filters['fecha_inicio_desde']);
        }

        if (!empty($filters['fecha_inicio_hasta'])) {
            $query->where('fecha_inicio', '<=', $filters['fecha_inicio_hasta']);
        }

        return $query->orderBy('fecha_creacion', 'desc')->get();
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
        if (!$proyecto)
            return null;

        $proyecto->update($datos);
        return $proyecto->fresh();
    }

    public function eliminar(int $id): bool
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto)
            return false;

        return (bool) $proyecto->delete();
    }
}

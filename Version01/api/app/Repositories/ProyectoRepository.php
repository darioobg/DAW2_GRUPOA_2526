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

        // Filtros explícitos
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

        // Si hay búsqueda general 'q' (Soporta buscar en nombre y descripción)
        if (!empty($filters['q'])) {
            $qString = $filters['q'];
            $query->where(function ($q) use ($qString) {
                $q
                    ->where('nombre', 'like', '%' . $qString . '%')
                    ->orWhere('descripcion', 'like', '%' . $qString . '%');
            });
        }

        return $query->orderBy('fecha_creacion', 'desc')->get();
    }

    /**
     * Búsqueda general (usada para endpoint /proyectos/buscar?q=...)
     * Puede ajustarse según se requiera buscar solo en nombre o en varios campos.
     */
    public function buscar(array $filtros): Collection
    {
        $query = Proyecto::query();

        if (!empty($filtros['q'])) {
            $query->where(function ($q) use ($filtros) {
                $q
                    ->where('nombre', 'like', "%{$filtros['q']}%")
                    ->orWhere('descripcion', 'like', "%{$filtros['q']}%");
            });
        }

        if (!empty($filtros['nombre'])) {
            $query->where('nombre', 'like', "%{$filtros['nombre']}%");
        }

        if (!empty($filtros['id_estado_proyecto'])) {
            $query->where('id_estado_proyecto', $filtros['id_estado_proyecto']);
        }

        if (!empty($filtros['fecha_inicio_desde'])) {
            $query->whereDate('fecha_inicio', '>=', $filtros['fecha_inicio_desde']);
        }

        if (!empty($filtros['fecha_inicio_hasta'])) {
            $query->whereDate('fecha_inicio', '<=', $filtros['fecha_inicio_hasta']);
        }

        return $query
            ->orderBy('nombre', 'asc')
            ->limit(20)
            ->get();
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

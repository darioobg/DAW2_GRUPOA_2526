<?php

namespace App\Services;

use App\Models\Proyecto;
use App\Repositories\ProyectoRepository;
use Illuminate\Support\Carbon;
use Exception;

class ProyectoService
{
    public function __construct(
        private ProyectoRepository $repo
    ) {}

    /**
     * Lista los proyectos filtrados por los parámetros dados.
     *
     * @param array $filters
     * @return array
     */
    public function listar(array $filters = []): array
    {
        $proyectos = $this->repo->obtenerTodos($filters);

        return $proyectos
            ->map(fn(Proyecto $p) => $this->toViewModel($p))
            ->toArray();
    }

    /**
     * Busca proyectos por un término de búsqueda.
     *
     * @param string|null $query
     * @return array
     */
    public function buscar(array $filtros): array
    {
        $proyectos = $this->repo->buscar($filtros);

        return $proyectos
            ->map(fn(Proyecto $p) => $this->toViewModel($p))
            ->toArray();
    }

    public function obtener(int $id): array
    {
        $proyecto = $this->repo->obtenerPorId($id);

        if (!$proyecto) {
            throw new Exception('Proyecto no encontrado.');
        }

        return $this->toViewModel($proyecto);
    }

    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre del proyecto es obligatorio.');
        }

        $idEquipo = (int) ($datos['id_equipo'] ?? 0);
        if ($idEquipo <= 0) {
            throw new Exception('El id_equipo es obligatorio.');
        }

        $idEstado = (int) ($datos['id_estado_proyecto'] ?? 0);
        if ($idEstado <= 0) {
            throw new Exception('El id_estado_proyecto es obligatorio.');
        }

        $fechaInicio = $this->parseDateOrThrow($datos['fecha_inicio'] ?? null, 'fecha_inicio');
        $fechaFinPrevista = $this->parseDateOrThrow($datos['fecha_fin_prevista'] ?? null, 'fecha_fin_prevista');

        if (Carbon::parse($fechaFinPrevista)->lt(Carbon::parse($fechaInicio))) {
            throw new Exception('La fecha_fin_prevista no puede ser anterior a la fecha_inicio.');
        }

        $fechaCreacion = $datos['fecha_creacion'] ?? now()->toDateString();

        $nuevo = $this->repo->crear([
            'id_equipo' => $idEquipo,
            'nombre' => $nombre,
            'descripcion' => $datos['descripcion'] ?? null,
            'fecha_creacion' => $fechaCreacion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin_prevista' => $fechaFinPrevista,
            'id_estado_proyecto' => $idEstado,
        ]);

        return $this->toViewModel($nuevo);
    }

    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Proyecto no encontrado.');
        }

        $payload = [];

        if (array_key_exists('id_equipo', $datos)) {
            $idEquipo = (int) $datos['id_equipo'];
            if ($idEquipo <= 0)
                throw new Exception('id_equipo inválido.');
            $payload['id_equipo'] = $idEquipo;
        }

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string) $datos['nombre']);
            if ($nombre === '')
                throw new Exception('El nombre del proyecto no puede estar vacío.');
            $payload['nombre'] = $nombre;
        }

        if (array_key_exists('descripcion', $datos)) {
            $payload['descripcion'] = $datos['descripcion'];  // puede ser null
        }

        if (array_key_exists('fecha_creacion', $datos)) {
            $payload['fecha_creacion'] = $this->parseDateOrThrow($datos['fecha_creacion'], 'fecha_creacion');
        }

        if (array_key_exists('fecha_inicio', $datos)) {
            $payload['fecha_inicio'] = $this->parseDateOrThrow($datos['fecha_inicio'], 'fecha_inicio');
        }

        if (array_key_exists('fecha_fin_prevista', $datos)) {
            $payload['fecha_fin_prevista'] = $this->parseDateOrThrow($datos['fecha_fin_prevista'], 'fecha_fin_prevista');
        }

        if (array_key_exists('id_estado_proyecto', $datos)) {
            $idEstado = (int) $datos['id_estado_proyecto'];
            if ($idEstado <= 0)
                throw new Exception('id_estado_proyecto inválido.');
            $payload['id_estado_proyecto'] = $idEstado;
        }

        // Validación cruzada de fechas (usando valores finales)
        $fechaInicioFinal = $payload['fecha_inicio'] ?? $actual->fecha_inicio;
        $fechaFinFinal = $payload['fecha_fin_prevista'] ?? $actual->fecha_fin_prevista;

        if ($fechaInicioFinal && $fechaFinFinal) {
            if (Carbon::parse($fechaFinFinal)->lt(Carbon::parse($fechaInicioFinal))) {
                throw new Exception('La fecha_fin_prevista no puede ser anterior a la fecha_inicio.');
            }
        }

        $editado = $this->repo->actualizar($id, $payload);
        if (!$editado) {
            throw new Exception('No se pudo actualizar el proyecto.');
        }

        return $this->toViewModel($editado);
    }

    /**
     * Elimina un proyecto.
     */
    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Proyecto no encontrado o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para el frontend
     */
    private function toViewModel(Proyecto $p): array
    {
        return [
            'id' => $p->id,
            'idEquipo' => $p->id_equipo,
            'nombre' => $p->nombre,
            'descripcion' => $p->descripcion,
            'fechaCreacion' => $p->fecha_creacion?->toDateString(),
            'fechaInicio' => $p->fecha_inicio?->toDateString(),
            'fechaFinPrevista' => $p->fecha_fin_prevista?->toDateString(),
            'idEstadoProyecto' => $p->id_estado_proyecto,
            'creadoHace' => $p->created_at
                ? Carbon::parse($p->created_at)->diffForHumans()
                : null,
            // 👇 AÑADIR ESTO
            'tareas' => $p->tareas->map(function ($t) {
                return [
                    'id' => $t->id,
                    'titulo' => $t->titulo,
                    'descripcion' => $t->descripcion,
                    'idEstado' => $t->id_estado,
                    'ordenKanban' => $t->orden_kanban,
                    'fechaCreacion' => $t->fecha_creacion,
                    'fechaLimite' => $t->fecha_limite,
                ];
            })->values()->toArray(),
        ];
    }

    private function parseDateOrThrow($value, string $campo): string
    {
        if ($value === null || $value === '') {
            throw new Exception("El campo {$campo} es obligatorio.");
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable $e) {
            throw new Exception("El campo {$campo} no tiene un formato de fecha válido.");
        }
    }
}

<?php

namespace App\Services;

use App\Models\Tarea;
use App\Repositories\TareaRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;

class TareaService
{
    public function __construct(
        private TareaRepository $repo
    ) {}

    public function listar(): array
    {
        $items = $this->repo->obtenerTodas();
        // dd($items->first());
        // dd($items->first()->toArray());
        // dd($this->toViewModel($items->first()));

        return $items
            ->map(fn(Tarea $t) => $this->toViewModel($t))
            ->toArray();
    }

    public function obtener(int $id): array
    {
        $tarea = $this->repo->obtenerPorId($id);

        if (!$tarea) {
            throw new Exception('Tarea no encontrada.');
        }

        return $this->toViewModel($tarea);
    }

    public function listarPorUsuario(int $userId): array
    {
        $tareas = $this->repo->obtenerPorUsuario($userId);

        return $tareas
            ->map(fn($t) => $this->toViewModel($t))
            ->toArray();
    }

    public function crear(array $datos): array
    {
        $titulo = trim($datos['titulo'] ?? '');
        if ($titulo === '') {
            throw new Exception('El título de la tarea es obligatorio.');
        }

        $idProyecto = (int) ($datos['id_proyecto'] ?? 0);
        if ($idProyecto <= 0) {
            throw new Exception('El id_proyecto es obligatorio.');
        }

        $idEstado = (int) ($datos['id_estado'] ?? 0);
        if ($idEstado <= 0) {
            throw new Exception('El id_estado es obligatorio.');
        }

        $idPrioridad = (int) ($datos['id_prioridad'] ?? 0);
        if ($idPrioridad <= 0) {
            throw new Exception('El id_prioridad es obligatorio.');
        }

        $fechaCreacion = $datos['fecha_creacion'] ?? now()->toDateString();
        $fechaLimite = $datos['fecha_limite'] ?? null;
        $fechaCierre = $datos['fecha_cierre'] ?? null;

        $nuevo = $this->repo->crear([
            'id_proyectos' => $idProyecto,
            'id_prioridad' => $idPrioridad,
            'id_asignado_a' => $datos['id_asignado_a'] ?? null,
            'id_estado' => $idEstado,
            'titulo' => $titulo,
            'descripcion' => $datos['descripcion'] ?? null,
            'fecha_creacion' => $this->parseDateOrThrow($fechaCreacion, 'fecha_creacion'),
            'fecha_limite' => $fechaLimite ? $this->parseDateOrThrow($fechaLimite, 'fecha_limite') : null,
            'fecha_cierre' => $fechaCierre ? $this->parseDateOrThrow($fechaCierre, 'fecha_cierre') : null,
            'orden_kanban' => $datos['orden_kanban'] ?? 0,
        ]);

        return $this->toViewModel($nuevo);
    }

    public function moverTarea(int $id, int $nuevoEstado, int $nuevoOrden): void
    {
        DB::transaction(function () use ($id, $nuevoEstado, $nuevoOrden) {
            $tarea = Tarea::findOrFail($id);

            $estadoOrigen = $tarea->id_estado;

            // 1️⃣ Ajustar tareas del destino
            Tarea::where('id_estado', $nuevoEstado)
                ->where('orden_kanban', '>=', $nuevoOrden)
                ->increment('orden_kanban');

            // 2️⃣ Actualizar tarea movida
            $tarea->update([
                'id_estado' => $nuevoEstado,
                'orden_kanban' => $nuevoOrden
            ]);

            // 3️⃣ Reordenar origen si cambió de columna
            if ($estadoOrigen !== $nuevoEstado) {
                $tareasOrigen = Tarea::where('id_estado', $estadoOrigen)
                    ->orderBy('orden_kanban')
                    ->get();

                foreach ($tareasOrigen as $index => $t) {
                    $t->update(['orden_kanban' => $index + 1]);
                }
            }
        });
    }

    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);

        if (!$actual) {
            throw new Exception('Tarea no encontrada.');
        }

        $payload = [];

        if (array_key_exists('titulo', $datos)) {
            $titulo = trim((string) $datos['titulo']);
            if ($titulo === '') {
                throw new Exception('El título no puede estar vacío.');
            }
            $payload['titulo'] = $titulo;
        }

        if (array_key_exists('id_proyecto', $datos)) {
            $idProyecto = (int) $datos['id_proyecto'];
            if ($idProyecto <= 0)
                throw new Exception('id_proyecto inválido.');
            $payload['id_proyecto'] = $idProyecto;
        }

        if (array_key_exists('id_estado', $datos)) {
            $idEstado = (int) $datos['id_estado'];
            if ($idEstado <= 0)
                throw new Exception('id_estado inválido.');
            $payload['id_estado'] = $idEstado;
        }

        if (array_key_exists('id_prioridad', $datos)) {
            $idPrioridad = (int) $datos['id_prioridad'];
            if ($idPrioridad <= 0)
                throw new Exception('id_prioridad inválido.');
            $payload['id_prioridad'] = $idPrioridad;
        }

        if (array_key_exists('id_asignado_a', $datos)) {
            $payload['id_asignado_a'] = $datos['id_asignado_a'] !== null
                ? (int) $datos['id_asignado_a']
                : null;
        }

        if (array_key_exists('descripcion', $datos)) {
            $payload['descripcion'] = $datos['descripcion'];
        }

        if (array_key_exists('fecha_creacion', $datos)) {
            $payload['fecha_creacion'] = $this->parseDateOrThrow($datos['fecha_creacion'], 'fecha_creación');
        }

        if (array_key_exists('fecha_limite', $datos)) {
            $payload['fecha_limite'] = $datos['fecha_limite']
                ? $this->parseDateOrThrow($datos['fecha_limite'], 'fecha_limite')
                : null;
        }

        if (array_key_exists('fecha_cierre', $datos)) {
            $payload['fecha_cierre'] = $datos['fecha_cierre']
                ? $this->parseDateOrThrow($datos['fecha_cierre'], 'fecha_cierre')
                : null;
        }

        if (array_key_exists('orden_kanban', $datos)) {
            $payload['orden_kanban'] = (int) $datos['orden_kanban'];
        }

        $editado = $this->repo->actualizar($id, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar la tarea.');
        }

        return $this->toViewModel($editado);
    }

    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Tarea no encontrada o no se pudo eliminar.');
        }
    }

    private function toViewModel(Tarea $t): array
    {
        return [
            'id' => $t->id,
            // IDs (útiles para backend y formularios)
            'idProyecto' => $t->id_proyectos,
            'idEstado' => $t->id_estado,
            'idAsignadoA' => $t->id_asignado_a,
            'idPrioridad' => $t->id_prioridad,
            // Datos descriptivos (para UI)
            'proyectoNombre' => $t->proyecto?->nombre,
            'estadoNombre' => $t->estado_tarea?->nombre,
            'prioridadNombre' => $t->prioridad?->nombre,
            'prioridadColor' => $t->prioridad?->color ?? null,
            'titulo' => $t->titulo,
            'descripcion' => $t->descripcion,
            'fechaCreacion' => $t->fecha_creacion?->toDateString(),
            'fechaLimite' => $t->fecha_limite?->toDateString(),
            'fechaCierre' => $t->fecha_cierre?->toDateString(),
            'ordenKanban' => $t->orden_kanban,
            'creadoHace' => $t->fecha_creacion
                ? $t->fecha_creacion->diffForHumans()
                : null,
        ];
    }

    private function parseDateOrThrow($value, string $campo): string
    {
        if ($value === null || $value === '') {
            throw new Exception("El campo {$campo} es obligatorio.");
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable) {
            throw new Exception("El campo {$campo} no tiene un formato de fecha válido.");
        }
    }
}

<?php

namespace App\Services;

use App\Models\EstadoTarea;
use App\Repositories\EstadoTareaRepository;
use Illuminate\Support\Carbon;
use Exception;

class EstadoTareaService
{
    public function __construct(
        private EstadoTareaRepository $repo
    ) {}

    public function listarPorProyecto(int $idProyecto): array
    {
        return $this
            ->repo
            ->obtenerPorProyecto($idProyecto)
            ->map(fn($e) => $this->toViewModel($e))
            ->toArray();
    }

    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre de la columna es obligatorio.');
        }

        if (!isset($datos['id_proyecto'])) {
            throw new Exception('La columna debe pertenecer a un proyecto.');
        }

        $nuevo = $this->repo->crear([
            'nombre' => $nombre,
            'orden' => $datos['orden'] ?? 0,
            'id_proyecto' => $datos['id_proyecto']
        ]);

        return $this->toViewModel($nuevo);
    }

    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Columna no encontrada.');
        }

        $payload = [];

        if (isset($datos['nombre'])) {
            $payload['nombre'] = trim($datos['nombre']);
        }

        if (isset($datos['orden'])) {
            $payload['orden'] = (int) $datos['orden'];
        }

        $editado = $this->repo->actualizar($id, $payload);

        return $this->toViewModel($editado);
    }

    public function eliminar(int $id): void
    {
        if (!$this->repo->eliminar($id)) {
            throw new Exception('Columna no encontrada.');
        }
    }

    private function toViewModel(EstadoTarea $e): array
    {
        return [
            'id' => $e->id,
            'nombre' => $e->nombre,
            'orden' => $e->orden,
            'idProyecto' => $e->id_proyecto,
            'creadoHace' => $e->created_at?->diffForHumans(),
        ];
    }
}

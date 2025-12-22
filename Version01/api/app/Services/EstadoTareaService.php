<?php

namespace App\Services;

use App\Models\EstadoTarea;
use App\Repositories\EstadoTareaRepository;
use Illuminate\Support\Carbon;
use Exception;

class EstadoTareaService
{
    private const NOMBRES_VALIDOS = [
        'PENDIENTE',
        'EN_PROGRESO',
        'FINALIZADA',
    ];

    public function __construct(
        private EstadoTareaRepository $repo
    ) {}

    public function listar(): array
    {
        $estados = $this->repo->obtenerTodos();

        return $estados
            ->map(fn (EstadoTarea $e) => $this->toViewModel($e))
            ->toArray();
    }

    public function obtener(int $id): array
    {
        $estado = $this->repo->obtenerPorId($id);

        if (!$estado) {
            throw new Exception('Estado de tarea no encontrado.');
        }

        return $this->toViewModel($estado);
    }

    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre del estado de tarea es obligatorio.');
        }

        if (!in_array($nombre, self::NOMBRES_VALIDOS, true)) {
            throw new Exception(
                'Estado inválido. Valores permitidos: ' . implode(', ', self::NOMBRES_VALIDOS)
            );
        }
        $orden = trim($datos['orden'] ?? '');

        $nuevo = $this->repo->crear([
            'nombre' => $nombre,
            'orden' => $orden
        ]);

        return $this->toViewModel($nuevo);
    }

    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Estado de tarea no encontrado.');
        }

        $payload = [];

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') {
                throw new Exception('El nombre no puede estar vacío.');
            }

            if (!in_array($nombre, self::NOMBRES_VALIDOS, true)) {
                throw new Exception(
                    'Estado inválido. Valores permitidos: ' . implode(', ', self::NOMBRES_VALIDOS)
                );
            }

            $payload['nombre'] = $nombre;
        }

        $editado = $this->repo->actualizar($id, $payload);
        if (!$editado) {
            throw new Exception('No se pudo actualizar el estado de tarea.');
        }

        return $this->toViewModel($editado);
    }

    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Estado de tarea no encontrado o no se pudo eliminar.');
        }
    }

    private function toViewModel(EstadoTarea $e): array
    {
        return [
            'id'         => $e->id,
            'nombre'     => $e->nombre,
            'creadoHace' => $e->created_at
                ? Carbon::parse($e->created_at)->diffForHumans()
                : null,
        ];
    }
}



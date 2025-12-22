<?php

namespace App\Services;

use App\Models\EstadoProyecto;
use App\Repositories\EstadoProyectoRepository;
use Illuminate\Support\Carbon;
use Exception;

class EstadoProyectoService
{
    private const NOMBRES_VALIDOS = [
        'ACTIVO',
        'ARCHIVADO',
    ];

    public function __construct(
        private EstadoProyectoRepository $repo
    ) {}

    public function listar(): array
    {
        $estados = $this->repo->obtenerTodos();

        return $estados
            ->map(fn (EstadoProyecto $e) => $this->toViewModel($e))
            ->toArray();
    }

    public function obtener(int $id): array
    {
        $estado = $this->repo->obtenerPorId($id);

        if (!$estado) {
            throw new Exception('Estado de proyecto no encontrado.');
        }

        return $this->toViewModel($estado);
    }

    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre del estado de proyecto es obligatorio.');
        }
        $estado = strtoupper(trim($datos['estado'] ?? ''));

        if (!in_array($estado, self::NOMBRES_VALIDOS, true)) {
            throw new Exception(
                'Estado inválido. Valores permitidos: ' . implode(', ', self::NOMBRES_VALIDOS)
            );
        }

        $nuevo = $this->repo->crear([
            'nombre' => $nombre,
        ]);

        return $this->toViewModel($nuevo);
    }

    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Estado de proyecto no encontrado.');
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
            throw new Exception('No se pudo actualizar el estado de proyecto.');
        }

        return $this->toViewModel($editado);
    }

    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Estado de proyecto no encontrado o no se pudo eliminar.');
        }
    }

    private function toViewModel(EstadoProyecto $e): array
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

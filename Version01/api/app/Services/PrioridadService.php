<?php

namespace App\Services;

use App\Models\Prioridad;
use App\Repositories\PrioridadRepository;
use Illuminate\Support\Carbon;
use Exception;

class PrioridadService
{
    
    private const NOMBRES_VALIDOS = [
        'BAJA',
        'MEDIA',
        'ALTA',
    ];

    public function __construct(
        private PrioridadRepository $repo
    ) {}

    public function listar(): array
    {
        $prioridades = $this->repo->obtenerTodos();

        return $prioridades
            ->map(fn (Prioridad $p) => $this->toViewModel($p))
            ->toArray();
    }

    public function obtener(int $id): array
    {
        $prioridad = $this->repo->obtenerPorId($id);

        if (!$prioridad) {
            throw new Exception('Prioridad no encontrada.');
        }

        return $this->toViewModel($prioridad);
    }

    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre de la prioridad es obligatorio.');
        }

        if (!in_array($nombre, self::NOMBRES_VALIDOS, true)) {
            throw new Exception(
                'Prioridad inválida. Valores permitidos: ' . implode(', ', self::NOMBRES_VALIDOS)
            );
        }

        $nueva = $this->repo->crear([
            'nombre' => $nombre,
        ]);

        return $this->toViewModel($nueva);
    }

    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Prioridad no encontrada.');
        }

        $payload = [];

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') {
                throw new Exception('El nombre no puede estar vacío.');
            }

            if (!in_array($nombre, self::NOMBRES_VALIDOS, true)) {
                throw new Exception(
                    'Prioridad inválida. Valores permitidos: ' . implode(', ', self::NOMBRES_VALIDOS)
                );
            }

            $payload['nombre'] = $nombre;
        }

        $editada = $this->repo->actualizar($id, $payload);
        if (!$editada) {
            throw new Exception('No se pudo actualizar la prioridad.');
        }

        return $this->toViewModel($editada);
    }

    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Prioridad no encontrada o no se pudo eliminar.');
        }
    }

    private function toViewModel(Prioridad $p): array
    {
        return [
            'id'         => $p->id_prioridad,
            'nombre'     => $p->nombre,
            'creadoHace' => $p->created_at
                ? Carbon::parse($p->created_at)->diffForHumans()
                : null,
        ];
    }
}

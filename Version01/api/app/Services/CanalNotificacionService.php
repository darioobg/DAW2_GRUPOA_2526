<?php

namespace App\Services;

use App\Models\CanalNotificacion;
use App\Repositories\CanalNotificacionRepository;
use Exception;

class CanalNotificacionService
{
    public function __construct(
        private CanalNotificacionRepository $repo
    ) {}

    public function listar(): array
    {
        $items = $this->repo->obtenerTodos();

        return $items
            ->map(fn (CanalNotificacion $c) => $this->toViewModel($c))
            ->toArray();
    }

    public function obtener(int $id): array
    {
        $canal = $this->repo->obtenerPorId($id);

        if (!$canal) {
            throw new Exception('Canal de notificación no encontrado.');
        }

        return $this->toViewModel($canal);
    }

    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre del canal es obligatorio.');
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
            throw new Exception('Canal de notificación no encontrado.');
        }

        $payload = [];

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') {
                throw new Exception('El nombre no puede estar vacío.');
            }
            $payload['nombre'] = $nombre;
        }

        $editado = $this->repo->actualizar($id, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar el canal.');
        }

        return $this->toViewModel($editado);
    }

    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Canal no encontrado o no se pudo eliminar.');
        }
    }

    private function toViewModel(CanalNotificacion $c): array
    {
        return [
            'id'     => $c->id_canal_notificacion,
            'nombre' => $c->nombre,
        ];
    }
}

<?php

namespace App\Services;

use App\Models\TipoNotificacion;
use App\Repositories\TipoNotificacionRepository;
use Exception;

class TipoNotificacionService
{
    public function __construct(
        private TipoNotificacionRepository $repo
    ) {}

    /**
     * Devuelve todos los tipos de notificación formateados para el frontend.
     */
    public function listar(): array
    {
        $items = $this->repo->obtenerTodos();

        return $items
            ->map(fn (TipoNotificacion $t) => $this->toViewModel($t))
            ->toArray();
    }

    /**
     * Devuelve un tipo de notificación por ID.
     */
    public function obtener(int $id): array
    {
        $tipo = $this->repo->obtenerPorId($id);

        if (!$tipo) {
            throw new Exception('Tipo de notificación no encontrado.');
        }

        return $this->toViewModel($tipo);
    }

    /**
     * Crea un tipo de notificación con validaciones de negocio.
     */
    public function crear(array $datos): array
    {
        // Validación: nombre obligatorio
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre del tipo de notificación es obligatorio.');
        }

        // Validación: enum válido (si aplica en tu modelo)
        if (isset($datos['enum'])) {
            $enum = trim($datos['enum']);
            if (!in_array($enum, ['ASIGNACIÓN', 'CAMBIO_ESTADO', 'COMENTARIO'])) {
                throw new Exception('El valor del enum no es válido.');
            }
        }

        $nuevo = $this->repo->crear([
            'nombre' => $nombre,
        ]);

        return $this->toViewModel($nuevo);
    }

    /**
     * Actualiza un tipo de notificación existente.
     */
    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);

        if (!$actual) {
            throw new Exception('Tipo de notificación no encontrado.');
        }

        $payload = [];

        // nombre
        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') {
                throw new Exception('El nombre no puede estar vacío.');
            }
            $payload['nombre'] = $nombre;
        }

        // enum (si aplica)
        if (array_key_exists('enum', $datos)) {
            $enum = trim((string)$datos['enum']);
            if (!in_array($enum, ['ASIGNACIÓN', 'CAMBIO_ESTADO', 'COMENTARIO'])) {
                throw new Exception('El valor del enum no es válido.');
            }
            $payload['enum'] = $enum;
        }

        $editado = $this->repo->actualizar($id, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar el tipo de notificación.');
        }

        return $this->toViewModel($editado);
    }

    /**
     * Elimina un tipo de notificación.
     */
    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Tipo de notificación no encontrado o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para el frontend.
     */
    private function toViewModel(TipoNotificacion $t): array
    {
        return [
            'id'     => $t->id,
            'nombre' => $t->nombre,
        ];
    }
}

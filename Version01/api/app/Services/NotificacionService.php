<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Repositories\NotificacionRepository;
use Illuminate\Support\Carbon;
use Exception;

class NotificacionService
{
    public function __construct(
        private NotificacionRepository $repo
    ) {}

    /**
     * Devuelve todas las notificaciones formateadas para el frontend.
     */
    public function listar(): array
    {
        $items = $this->repo->obtenerTodas();

        return $items
            ->map(fn (Notificacion $n) => $this->toViewModel($n))
            ->toArray();
    }

    /**
     * Devuelve una notificación por ID.
     */
    public function obtener(int $id): array
    {
        $notificacion = $this->repo->obtenerPorId($id);

        if (!$notificacion) {
            throw new Exception('Notificación no encontrada.');
        }

        return $this->toViewModel($notificacion);
    }

    /**
     * Crea una notificación con validaciones de negocio.
     */
    public function crear(array $datos): array
    {
        // Validación: mensaje obligatorio
        $mensaje = trim($datos['mensaje'] ?? '');
        if ($mensaje === '') {
            throw new Exception('El mensaje de la notificación es obligatorio.');
        }

        // Validación: id_usuario_destino obligatorio
        $idUsuarioDestino = (int)($datos['id_usuario_destino'] ?? 0);
        if ($idUsuarioDestino <= 0) {
            throw new Exception('El id_usuario_destino es obligatorio.');
        }

        // Validación: id_tarea obligatorio
        $idTarea = (int)($datos['id_tarea'] ?? 0);
        if ($idTarea <= 0) {
            throw new Exception('El id_tarea es obligatorio.');
        }

        // Validación: id_tipo_notificacion obligatorio
        $idTipo = (int)($datos['id_tipo_notificacion'] ?? 0);
        if ($idTipo <= 0) {
            throw new Exception('El id_tipo_notificacion es obligatorio.');
        }

        // Validación: id_canal_notificacion obligatorio
        $idCanal = (int)($datos['id_canal_notificacion'] ?? 0);
        if ($idCanal <= 0) {
            throw new Exception('El id_canal_notificacion es obligatorio.');
        }

        // Fecha de envío
        $fechaEnvio = $datos['fecha_envío'] ?? now()->toDateString();
        $fechaEnvio = $this->parseDateOrThrow($fechaEnvio, 'fecha_envío');

        $nuevo = $this->repo->crear([
            'id_usuario_destino'   => $idUsuarioDestino,
            'id_tarea'             => $idTarea,
            'id_tipo_notificacion' => $idTipo,
            'id_canal_notificacion'=> $idCanal,
            'mensaje'              => $mensaje,
            'leída'                => (bool)($datos['leída'] ?? false),
            'fecha_envío'          => $fechaEnvio,
        ]);

        return $this->toViewModel($nuevo);
    }

    /**
     * Actualiza una notificación existente.
     */
    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);

        if (!$actual) {
            throw new Exception('Notificación no encontrada.');
        }

        $payload = [];

        // id_usuario_destino
        if (array_key_exists('id_usuario_destino', $datos)) {
            $idUsuarioDestino = (int)$datos['id_usuario_destino'];
            if ($idUsuarioDestino <= 0) {
                throw new Exception('id_usuario_destino inválido.');
            }
            $payload['id_usuario_destino'] = $idUsuarioDestino;
        }

        // id_tarea
        if (array_key_exists('id_tarea', $datos)) {
            $idTarea = (int)$datos['id_tarea'];
            if ($idTarea <= 0) {
                throw new Exception('id_tarea inválido.');
            }
            $payload['id_tarea'] = $idTarea;
        }

        // id_tipo_notificacion
        if (array_key_exists('id_tipo_notificacion', $datos)) {
            $idTipo = (int)$datos['id_tipo_notificacion'];
            if ($idTipo <= 0) {
                throw new Exception('id_tipo_notificacion inválido.');
            }
            $payload['id_tipo_notificacion'] = $idTipo;
        }

        // id_canal_notificacion
        if (array_key_exists('id_canal_notificacion', $datos)) {
            $idCanal = (int)$datos['id_canal_notificacion'];
            if ($idCanal <= 0) {
                throw new Exception('id_canal_notificacion inválido.');
            }
            $payload['id_canal_notificacion'] = $idCanal;
        }

        // mensaje
        if (array_key_exists('mensaje', $datos)) {
            $mensaje = trim((string)$datos['mensaje']);
            if ($mensaje === '') {
                throw new Exception('El mensaje no puede estar vacío.');
            }
            $payload['mensaje'] = $mensaje;
        }

        // leída
        if (array_key_exists('leída', $datos)) {
            $payload['leída'] = (bool)$datos['leída'];
        }

        // fecha_envío
        if (array_key_exists('fecha_envío', $datos)) {
            $payload['fecha_envío'] = $this->parseDateOrThrow(
                $datos['fecha_envío'],
                'fecha_envío'
            );
        }

        $editado = $this->repo->actualizar($id, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar la notificación.');
        }

        return $this->toViewModel($editado);
    }

    /**
     * Elimina una notificación.
     */
    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Notificación no encontrada o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para el frontend.
     */
    private function toViewModel(Notificacion $n): array
    {
        return [
            'id'         => $n->id,
            'usuarioId'  => $n->id_usuario_destino,
            'tareaId'    => $n->id_tarea,
            'tipoId'     => $n->id_tipo_notificacion,
            'canalId'    => $n->id_canal_notificacion,
            'mensaje'    => $n->mensaje,
            'leida'      => (bool)$n->leída,
            'fechaEnvio' => $n->fecha_envío
                ? Carbon::parse($n->fecha_envío)->toDateString()
                : null,
            'enviadaHace'=> $n->fecha_envío
                ? Carbon::parse($n->fecha_envío)->diffForHumans()
                : null,
        ];
    }

    /**
     * Helper para validar fechas.
     */
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

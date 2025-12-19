<?php

namespace App\Services;

use App\Models\Comentario;
use App\Repositories\ComentarioRepository;
use Illuminate\Support\Carbon;
use Exception;

class ComentarioService
{
    public function __construct(
        private ComentarioRepository $repo
    ) {}

    /**
     * Devuelve todos los comentarios formateados para el frontend.
     */
    public function listar(): array
    {
        $comentarios = $this->repo->obtenerTodos();

        return $comentarios
            ->map(fn (Comentario $c) => $this->toViewModel($c))
            ->toArray();
    }

    /**
     * Devuelve un comentario por ID.
     */
    public function obtener(int $id): array
    {
        $comentario = $this->repo->obtenerPorId($id);

        if (!$comentario) {
            throw new Exception('Comentario no encontrado.');
        }

        return $this->toViewModel($comentario);
    }

    /**
     * Crea un comentario con validaciones de negocio.
     */
    public function crear(array $datos): array
    {
        // Validación: texto obligatorio
        $texto = trim($datos['texto'] ?? '');
        if ($texto === '') {
            throw new Exception('El texto del comentario es obligatorio.');
        }

        // Validación: id_tarea obligatorio
        $idTarea = (int)($datos['id_tarea'] ?? 0);
        if ($idTarea <= 0) {
            throw new Exception('El id_tarea es obligatorio.');
        }

        // Validación: id_usuario obligatorio
        $idUsuario = (int)($datos['id_usuario'] ?? 0);
        if ($idUsuario <= 0) {
            throw new Exception('El id_usuario es obligatorio.');
        }

        // Fechas
        $fechaCreacion = $datos['fecha_creacion'] ?? now()->toDateString();
        $fechaEdicion  = $datos['fecha_edicion'] ?? null;

        if ($fechaEdicion !== null) {
            $fechaEdicion = $this->parseDateOrThrow($fechaEdicion, 'fecha_edicion');
        }

        $nuevo = $this->repo->crear([
            'id_tarea'       => $idTarea,
            'id_usuario'     => $idUsuario,
            'texto'          => $texto,
            'fecha_creacion' => $this->parseDateOrThrow($fechaCreacion, 'fecha_creacion'),
            'fecha_edicion'  => $fechaEdicion,
        ]);

        return $this->toViewModel($nuevo);
    }

    /**
     * Actualiza un comentario existente.
     */
    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);

        if (!$actual) {
            throw new Exception('Comentario no encontrado.');
        }

        $payload = [];

        // id_tarea
        if (array_key_exists('id_tarea', $datos)) {
            $idTarea = (int)$datos['id_tarea'];
            if ($idTarea <= 0) {
                throw new Exception('id_tarea inválido.');
            }
            $payload['id_tarea'] = $idTarea;
        }

        // id_usuario
        if (array_key_exists('id_usuario', $datos)) {
            $idUsuario = (int)$datos['id_usuario'];
            if ($idUsuario <= 0) {
                throw new Exception('id_usuario inválido.');
            }
            $payload['id_usuario'] = $idUsuario;
        }

        // texto
        if (array_key_exists('texto', $datos)) {
            $texto = trim((string)$datos['texto']);
            if ($texto === '') {
                throw new Exception('El texto del comentario no puede estar vacío.');
            }
            $payload['texto'] = $texto;
        }

        // fecha_creacion
        if (array_key_exists('fecha_creacion', $datos)) {
            $payload['fecha_creacion'] = $this->parseDateOrThrow(
                $datos['fecha_creacion'],
                'fecha_creacion'
            );
        }

        // fecha_edicion
        if (array_key_exists('fecha_edicion', $datos)) {
            $payload['fecha_edicion'] = $this->parseDateOrThrow(
                $datos['fecha_edicion'],
                'fecha_edicion'
            );
        } else {
            // Si se actualiza cualquier campo, marcamos fecha_edicion automáticamente
            if (!empty($payload)) {
                $payload['fecha_edicion'] = now()->toDateString();
            }
        }

        $editado = $this->repo->actualizar($id, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar el comentario.');
        }

        return $this->toViewModel($editado);
    }

    /**
     * Elimina un comentario.
     */
    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Comentario no encontrado o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para el frontend.
     */
    private function toViewModel(Comentario $c): array
    {
        return [
            'id'         => $c->id_comentario,
            'idTarea'    => $c->id_tarea,
            'idUsuario'  => $c->id_usuario,
            'texto'      => $c->texto,
            'fechaCreacion' => $c->fecha_creacion
                ? Carbon::parse($c->fecha_creacion)->toDateString()
                : null,
            'fechaEdicion' => $c->fecha_edicion
                ? Carbon::parse($c->fecha_edicion)->toDateString()
                : null,
            'creadoHace' => $c->fecha_creacion
                ? Carbon::parse($c->fecha_creacion)->diffForHumans()
                : null,
            'editadoHace' => $c->fecha_edicion
                ? Carbon::parse($c->fecha_edicion)->diffForHumans()
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

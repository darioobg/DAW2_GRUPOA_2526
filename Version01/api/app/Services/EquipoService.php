<?php

namespace App\Services;

use App\Models\Equipo;
use App\Repositories\EquipoRepository;
use Illuminate\Support\Carbon;
use Exception;

class EquipoService
{
    public function __construct(
        private EquipoRepository $repo
    ) {}

    /**
     * Lista equipos (ViewModel)
     */
    public function listar(): array
    {
        $equipos = $this->repo->obtenerTodos();

        return $equipos
            ->map(fn (Equipo $e) => $this->toViewModel($e))
            ->toArray();
    }

    /**
     * Obtiene un equipo por id (ViewModel)
     */
    public function obtener(int $id): array
    {
        $equipo = $this->repo->obtenerPorId($id);

        if (!$equipo) {
            throw new Exception('Equipo no encontrado.');
        }

        return $this->toViewModel($equipo);
    }

    /**
     * Crea un equipo con validación básica de negocio
     */
    public function crear(array $datos): array
    {
        $idEmpresa = (int)($datos['id_empresa'] ?? 0);
        if ($idEmpresa <= 0) {
            throw new Exception('El id_empresa es obligatorio.');
        }

        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre del equipo es obligatorio.');
        }

        $activo = $datos['activo'] ?? true;
        if (!is_bool($activo) && !in_array($activo, [0, 1, '0', '1'], true)) {
            throw new Exception('El campo activo debe ser boolean.');
        }

        $nuevo = $this->repo->crear([
            'id_empresa'     => $idEmpresa,
            'nombre'         => $nombre,
            'descripcion'    => $datos['descripcion'] ?? null,
            'fecha_creacion' => $datos['fecha_creacion'] ?? now()->toDateString(),
            'activo'         => (bool)$activo,
        ]);

        return $this->toViewModel($nuevo);
    }

    /**
     * Actualiza un equipo existente
     */
    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Equipo no encontrado.');
        }

        $payload = [];

        if (array_key_exists('id_empresa', $datos)) {
            $idEmpresa = (int)$datos['id_empresa'];
            if ($idEmpresa <= 0) throw new Exception('id_empresa inválido.');
            $payload['id_empresa'] = $idEmpresa;
        }

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') throw new Exception('El nombre no puede estar vacío.');
            $payload['nombre'] = $nombre;
        }

        if (array_key_exists('descripcion', $datos)) {
            $payload['descripcion'] = $datos['descripcion']; // puede ser null
        }

        if (array_key_exists('fecha_creacion', $datos)) {
            $payload['fecha_creacion'] = $this->parseDateOrThrow($datos['fecha_creacion'], 'fecha_creacion');
        }

        if (array_key_exists('activo', $datos)) {
            $activo = $datos['activo'];
            if (!is_bool($activo) && !in_array($activo, [0, 1, '0', '1'], true)) {
                throw new Exception('El campo activo debe ser boolean.');
            }
            $payload['activo'] = (bool)$activo;
        }

        $editado = $this->repo->actualizar($id, $payload);
        if (!$editado) {
            throw new Exception('No se pudo actualizar el equipo.');
        }

        return $this->toViewModel($editado);
    }

    /**
     * Elimina un equipo
     */
    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Equipo no encontrado o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para frontend
     */
    private function toViewModel(Equipo $e): array
    {
        return [
            'id'            => $e->id_equipo,
            'idEmpresa'     => $e->id_empresa,
            'nombre'        => $e->nombre,
            'descripcion'   => $e->descripcion,
            'fechaCreacion' => $e->fecha_creacion?->toDateString(),
            'activo'        => (bool)$e->activo,
            'creadoHace'    => $e->created_at
                ? Carbon::parse($e->created_at)->diffForHumans()
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
        } catch (\Throwable $e) {
            throw new Exception("El campo {$campo} no tiene un formato de fecha válido.");
        }
    }
}

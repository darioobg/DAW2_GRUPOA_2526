<?php

namespace App\Services;

use App\Models\UsuarioEquipo;
use App\Repositories\UsuarioEquipoRepository;
use Illuminate\Support\Carbon;
use Exception;

class UsuarioEquipoService
{
    public function __construct(
        private UsuarioEquipoRepository $repo
    ) {}

    /**
     * Devuelve todas las relaciones usuario-equipo formateadas.
     */
    public function listar(): array
    {
        $items = $this->repo->obtenerTodos();

        return $items
            ->map(fn(UsuarioEquipo $u) => $this->toViewModel($u))
            ->toArray();
    }

    private function mapearEntrada(array $data): array
    {
        return [
            'id_usuario' => $data['idUsuario'] ?? null,
            'id_equipo' => $data['idEquipo'] ?? null,
            'id_rol_equipo' => $data['idRol'] ?? null,
            'fecha_alta' => $data['fechaAlta'] ?? null,
        ];
    }

    /**
     * Devuelve una relación usuario-equipo por IDs.
     */
    public function obtener(int $idUsuario, int $idEquipo): array
    {
        $registro = $this->repo->obtenerPorIds($idUsuario, $idEquipo);

        if (!$registro) {
            throw new Exception('Relación usuario-equipo no encontrada.');
        }

        return $this->toViewModel($registro);
    }

    /**
     * Crea una relación usuario-equipo con validaciones de negocio.
     */
    public function crear(array $datos): array
    {
        $datos = $this->mapearEntrada($datos);
        // id_usuario
        $idUsuario = (int) ($datos['id_usuario'] ?? 0);
        if ($idUsuario <= 0) {
            throw new Exception('El id_usuario es obligatorio.');
        }

        // id_equipo
        $idEquipo = (int) ($datos['id_equipo'] ?? 0);
        if ($idEquipo <= 0) {
            throw new Exception('El id_equipo es obligatorio.');
        }

        // id_rol_equipo
        $idRol = (int) ($datos['id_rol_equipo'] ?? 0);
        if ($idRol <= 0) {
            throw new Exception('El id_rol_equipo es obligatorio.');
        }

        // fecha_alta
        $fechaAlta = $datos['fecha_alta'] ?? now()->toDateString();
        $fechaAlta = $this->parseDateOrThrow($fechaAlta, 'fecha_alta');

        // activo
        $activo = (bool) ($datos['activo'] ?? true);

        $nuevo = $this->repo->crear([
            'id_usuario' => $idUsuario,
            'id_equipo' => $idEquipo,
            'id_rol_equipo' => $idRol,
            'fecha_alta' => $fechaAlta,
            'activo' => $activo,
        ]);

        return $this->toViewModel($nuevo);
    }

    /**
     * Actualiza una relación usuario-equipo existente.
     */
    public function actualizar(int $idUsuario, int $idEquipo, array $datos): array
    {
        $datos = $this->mapearEntrada($datos);
        $actual = $this->repo->obtenerPorIds($idUsuario, $idEquipo);

        if (!$actual) {
            throw new Exception('Relación usuario-equipo no encontrada.');
        }

        $payload = [];

        // id_rol_equipo
        if (array_key_exists('id_rol_equipo', $datos)) {
            $idRol = (int) $datos['id_rol_equipo'];
            if ($idRol <= 0) {
                throw new Exception('id_rol_equipo inválido.');
            }
            $payload['id_rol_equipo'] = $idRol;
        }

        // fecha_alta
        if (array_key_exists('fecha_alta', $datos)) {
            $payload['fecha_alta'] = $this->parseDateOrThrow($datos['fecha_alta'], 'fecha_alta');
        }

        // activo
        if (array_key_exists('activo', $datos)) {
            $payload['activo'] = (bool) $datos['activo'];
        }

        $editado = $this->repo->actualizar($idUsuario, $idEquipo, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar la relación usuario-equipo.');
        }

        return $this->toViewModel($editado);
    }

    /**
     * Elimina una relación usuario-equipo.
     */
    public function eliminar(int $idUsuario, int $idEquipo): void
    {
        $ok = $this->repo->eliminar($idUsuario, $idEquipo);

        if (!$ok) {
            throw new Exception('Relación usuario-equipo no encontrada o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para el frontend.
     */
    private function toViewModel(UsuarioEquipo $u): array
    {
        return [
            'idUsuario' => $u->id_usuario,
            'idEquipo' => $u->id_equipo,
            'idRol' => $u->id_rol_equipo,
            'fechaAlta' => $u->fecha_alta
                ? Carbon::parse($u->fecha_alta)->toDateString()
                : null,
            'activo' => (bool) $u->activo,
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
        } catch (\Throwable) {
            throw new Exception("El campo {$campo} no tiene un formato de fecha válido.");
        }
    }
}

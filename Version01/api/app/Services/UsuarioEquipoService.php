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

    public function listar(): array
    {
        $items = $this->repo->obtenerTodos();

        return $items
            ->map(fn (UsuarioEquipo $u) => $this->toViewModel($u))
            ->toArray();
    }

    public function obtener(int $idUsuario, int $idEquipo): array
    {
        $registro = $this->repo->obtenerPorIds($idUsuario, $idEquipo);

        if (!$registro) {
            throw new Exception('Relación usuario-equipo no encontrada.');
        }

        return $this->toViewModel($registro);
    }

    public function crear(array $datos): array
    {
        $idUsuario = (int)($datos['id_usuario'] ?? 0);
        if ($idUsuario <= 0) {
            throw new Exception('El id_usuario es obligatorio.');
        }

        $idEquipo = (int)($datos['id_equipo'] ?? 0);
        if ($idEquipo <= 0) {
            throw new Exception('El id_equipo es obligatorio.');
        }

        $idRol = (int)($datos['id_rol_equipo'] ?? 0);
        if ($idRol <= 0) {
            throw new Exception('El id_rol_equipo es obligatorio.');
        }

        $fechaAlta = $datos['fecha_alta'] ?? now()->toDateString();
        $fechaAlta = $this->parseDateOrThrow($fechaAlta, 'fecha_alta');

        $activo = (bool)($datos['activo'] ?? true);

        $nuevo = $this->repo->crear([
            'id_usuario'    => $idUsuario,
            'id_equipo'     => $idEquipo,
            'id_rol_equipo' => $idRol,
            'fecha_alta'    => $fechaAlta,
            'activo'        => $activo,
        ]);

        return $this->toViewModel($nuevo);
    }

    public function actualizar(int $idUsuario, int $idEquipo, array $datos): array
    {
        $actual = $this->repo->obtenerPorIds($idUsuario, $idEquipo);

        if (!$actual) {
            throw new Exception('Relación usuario-equipo no encontrada.');
        }

        $payload = [];

        if (array_key_exists('id_rol_equipo', $datos)) {
            $idRol = (int)$datos['id_rol_equipo'];
            if ($idRol <= 0) {
                throw new Exception('id_rol_equipo inválido.');
            }
            $payload['id_rol_equipo'] = $idRol;
        }

        if (array_key_exists('fecha_alta', $datos)) {
            $payload['fecha_alta'] = $this->parseDateOrThrow($datos['fecha_alta'], 'fecha_alta');
        }

        if (array_key_exists('activo', $datos)) {
            $payload['activo'] = (bool)$datos['activo'];
        }

        $editado = $this->repo->actualizar($idUsuario, $idEquipo, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar la relación usuario-equipo.');
        }

        return $this->toViewModel($editado);
    }

    public function eliminar(int $idUsuario, int $idEquipo): void
    {
        $ok = $this->repo->el
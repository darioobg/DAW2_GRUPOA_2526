<?php

namespace App\Services;

use App\Models\UsuarioEmpresa;
use App\Repositories\UsuarioEmpresaRepository;
use Illuminate\Support\Carbon;
use Exception;

class UsuarioEmpresaService
{
    public function __construct(
        private UsuarioEmpresaRepository $repo
    ) {}

    public function listar(): array
    {
        $items = $this->repo->obtenerTodos();

        return $items
            ->map(fn (UsuarioEmpresa $u) => $this->toViewModel($u))
            ->toArray();
    }

    public function obtener(int $idUsuario, int $idEmpresa): array
    {
        $registro = $this->repo->obtenerPorIds($idUsuario, $idEmpresa);

        if (!$registro) {
            throw new Exception('Relación usuario-empresa no encontrada.');
        }

        return $this->toViewModel($registro);
    }

    public function crear(array $datos): array
    {
        $idUsuario = (int)($datos['id_usuario'] ?? 0);
        if ($idUsuario <= 0) {
            throw new Exception('El id_usuario es obligatorio.');
        }

        $idEmpresa = (int)($datos['id_empresa'] ?? 0);
        if ($idEmpresa <= 0) {
            throw new Exception('El id_empresa es obligatorio.');
        }

        $idRol = (int)($datos['id_rol_empresa'] ?? 0);
        if ($idRol <= 0) {
            throw new Exception('El id_rol_empresa es obligatorio.');
        }

        $fechaAlta = $datos['fecha_alta'] ?? now()->toDateString();
        $fechaAlta = $this->parseDateOrThrow($fechaAlta, 'fecha_alta');

        $nuevo = $this->repo->crear([
            'id_usuario'     => $idUsuario,
            'id_empresa'     => $idEmpresa,
            'id_rol_empresa' => $idRol,
            'fecha_alta'     => $fechaAlta,
        ]);

        return $this->toViewModel($nuevo);
    }

    public function actualizar(int $idUsuario, int $idEmpresa, array $datos): array
    {
        $actual = $this->repo->obtenerPorIds($idUsuario, $idEmpresa);

        if (!$actual) {
            throw new Exception('Relación usuario-empresa no encontrada.');
        }

        $payload = [];

        if (array_key_exists('id_rol_empresa', $datos)) {
            $idRol = (int)$datos['id_rol_empresa'];
            if ($idRol <= 0) {
                throw new Exception('id_rol_empresa inválido.');
            }
            $payload['id_rol_empresa'] = $idRol;
        }

        if (array_key_exists('fecha_alta', $datos)) {
            $payload['fecha_alta'] = $this->parseDateOrThrow($datos['fecha_alta'], 'fecha_alta');
        }

        $editado = $this->repo->actualizar($idUsuario, $idEmpresa, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar la relación usuario-empresa.');
        }

        return $this->toViewModel($editado);
    }

    public function eliminar(int $idUsuario, int $idEmpresa): void
    {
        $ok = $this->repo->eliminar($idUsuario, $idEmpresa);

        if (!$ok) {
            throw new Exception('Relación usuario-empresa no encontrada o no se pudo eliminar.');
        }
    }

    private function toViewModel(UsuarioEmpresa $u): array
    {
        return [
            'idUsuario' => $u->id_usuario,
            'idEmpresa' => $u->id_empresa,
            'idRol'     => $u->id_rol_empresa,
            'fechaAlta' => $u->fecha_alta
                ? Carbon::parse($u->fecha_alta)->toDateString()
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
        } catch (\Throwable) {
            throw new Exception("El campo {$campo} no tiene un formato de fecha válido.");
        }

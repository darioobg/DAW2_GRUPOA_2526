<?php

namespace App\Services;

use App\Models\RolEmpresa;
use App\Repositories\RolEmpresaRepository;
use Exception;

class RolEmpresaService
{
    public function __construct(
        private RolEmpresaRepository $repo
    ) {}

    /**
     * Listar todos los roles de empresa
     */
    public function listar(): array
    {
        $roles = $this->repo->obtenerTodos();

        return $roles
            ->map(fn (RolEmpresa $r) => $this->toViewModel($r))
            ->toArray();
    }

    /**
     * Obtener un rol por ID
     */
    public function obtener(int $id): array
    {
        $rol = $this->repo->obtenerPorId($id);

        if (!$rol) {
            throw new Exception('Rol de empresa no encontrado.');
        }

        return $this->toViewModel($rol);
    }

    /**
     * Crear un nuevo rol
     */
    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');

        if ($nombre === '') {
            throw new Exception('El nombre del rol es obligatorio.');
        }

        $nuevo = $this->repo->crear([
            'nombre' => $nombre,
        ]);

        return $this->toViewModel($nuevo);
    }

    /**
     * Actualizar un rol existente
     */
    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);

        if (!$actual) {
            throw new Exception('Rol de empresa no encontrado.');
        }

        $payload = [];

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') {
                throw new Exception('El nombre del rol no puede estar vacío.');
            }
            $payload['nombre'] = $nombre;
        }

        $editado = $this->repo->actualizar($id, $payload);

        if (!$editado) {
            throw new Exception('No se pudo actualizar el rol.');
        }

        return $this->toViewModel($editado);
    }

    /**
     * Eliminar un rol
     */
    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Rol no encontrado o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para el frontend
     */
    private function toViewModel(RolEmpresa $r): array
    {
        return [
            'id'            => $r->id,
            'nombre'        => $r->nombre,
            'creadoEn'      => $r->created_at?->toDateString(),
            'actualizadoEn' => $r->updated_at?->toDateString(),
        ];
    }
}

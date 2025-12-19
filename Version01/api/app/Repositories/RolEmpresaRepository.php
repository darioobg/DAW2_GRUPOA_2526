<?php

namespace App\Repositories;

use App\Models\RolEmpresa;
use Illuminate\Database\Eloquent\Collection;

class RolEmpresaRepository
{
    public function obtenerTodos(): Collection
    {
        return RolEmpresa::orderBy('id_rol_empresa')->get();
    }

    public function obtenerPorId(int $id): ?RolEmpresa
    {
        return RolEmpresa::find($id);
    }

    public function crear(array $datos): RolEmpresa
    {
        return RolEmpresa::create($datos);
    }

    public function actualizar(int $id, array $datos): ?RolEmpresa
    {
        $rol = RolEmpresa::find($id);
        if (!$rol) return null;

        $rol->update($datos);
        return $rol->fresh();
    }

    public function eliminar(int $id): bool
    {
        $rol = RolEmpresa::find($id);
        if (!$rol) return false;

        return (bool) $rol->delete();
    }
}

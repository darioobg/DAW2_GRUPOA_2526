<?php

namespace App\Repositories;

use App\Models\RolEquipo;
use Illuminate\Database\Eloquent\Collection;

class RolEquipoRepository
{
    public function obtenerTodos(): Collection
    {
        return RolEquipo::orderBy('id_rol_equipo')->get();
    }

    public function obtenerPorId(int $id): ?RolEquipo
    {
        return RolEquipo::find($id);
    }

    public function crear(array $datos): RolEquipo
    {
        return RolEquipo::create($datos);
    }

    public function actualizar(int $id, array $datos): ?RolEquipo
    {
        $rol = RolEquipo::find($id);
        if (!$rol) return null;

        $rol->update($datos);
        return $rol->fresh();
    }

    public function eliminar(int $id): bool
    {
        $rol = RolEquipo::find($id);
        if (!$rol) return false;

        return (bool) $rol->delete();
    }
}

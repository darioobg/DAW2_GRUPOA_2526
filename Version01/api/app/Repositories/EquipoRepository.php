<?php

namespace App\Repositories;

use App\Models\Equipo;
use Illuminate\Database\Eloquent\Collection;

class EquipoRepository
{
    public function obtenerTodos(): Collection
    {
        return Equipo::orderBy('created_at', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Equipo
    {
        return Equipo::find($id);
    }

    public function crear(array $datos): Equipo
    {
        return Equipo::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Equipo
    {
        $equipo = Equipo::find($id);
        if (!$equipo) return null;

        $equipo->update($datos);
        return $equipo->fresh();
    }

    public function eliminar(int $id): bool
    {
        $equipo = Equipo::find($id);
        if (!$equipo) return false;

        return (bool) $equipo->delete();
    }
}

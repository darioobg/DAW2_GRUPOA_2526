<?php

namespace App\Repositories;

use App\Models\UsuarioEquipo;
use Illuminate\Database\Eloquent\Collection;

class UsuarioEquipoRepository
{
    public function obtenerTodos(): Collection
    {
        return UsuarioEquipo::orderBy('id_usuario', 'asc')->get();
    }

    public function obtenerPorIds(int $idUsuario, int $idEquipo): ?UsuarioEquipo
    {
        return UsuarioEquipo::where('id_usuario', $idUsuario)
                            ->where('id_equipo', $idEquipo)
                            ->first();
    }

    public function crear(array $datos): UsuarioEquipo
    {
        return UsuarioEquipo::create($datos);
    }

    public function actualizar(int $idUsuario, int $idEquipo, array $datos): ?UsuarioEquipo
    {
        $registro = $this->obtenerPorIds($idUsuario, $idEquipo);
        if (!$registro) return null;

        $registro->update($datos);
        return $registro->fresh();
    }

    public function eliminar(int $idUsuario, int $idEquipo): bool
    {
        $registro = $this->obtenerPorIds($idUsuario, $idEquipo);
        if (!$registro) return false;

        return (bool) $registro->delete();
    }
}

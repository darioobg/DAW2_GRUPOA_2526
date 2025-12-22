<?php

namespace App\Repositories;

use App\Models\UsuarioEmpresa;
use Illuminate\Database\Eloquent\Collection;

class UsuarioEmpresaRepository
{
    public function obtenerTodos(): Collection
    {
        return UsuarioEmpresa::orderBy('id_usuario', 'asc')->get();
    }

    public function obtenerPorIds(int $idUsuario, int $idEmpresa): ?UsuarioEmpresa
    {
        return UsuarioEmpresa::where('id_usuario', $idUsuario)
                             ->where('id_empresa', $idEmpresa)
                             ->first();
    }

    public function crear(array $datos): UsuarioEmpresa
    {
        return UsuarioEmpresa::create($datos);
    }

    public function actualizar(int $idUsuario, int $idEmpresa, array $datos): ?UsuarioEmpresa
    {
        $registro = $this->obtenerPorIds($idUsuario, $idEmpresa);
        if (!$registro) return null;

        $registro->update($datos);
        return $registro->fresh();
    }

    public function eliminar(int $idUsuario, int $idEmpresa): bool
    {
        $registro = $this->obtenerPorIds($idUsuario, $idEmpresa);
        if (!$registro) return false;

        return (bool) $registro->delete();
    }
}

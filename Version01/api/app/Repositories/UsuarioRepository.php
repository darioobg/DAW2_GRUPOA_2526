<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Collection;

class UsuarioRepository
{
    public function obtenerTodos(): Collection
    {
        return Usuario::orderBy('created_at', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Usuario
    {
        return Usuario::find($id);
    }

    public function crear(array $datos): Usuario
    {
        return Usuario::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Usuario
    {
        $usuario = Usuario::find($id);
        if (!$usuario) return null;

        $usuario->update($datos);
        return $usuario->fresh();
    }

    public function eliminar(int $id): bool
    {
        $usuario = Usuario::find($id);
        if (!$usuario) return false;

        return (bool) $usuario->delete();
    }
}

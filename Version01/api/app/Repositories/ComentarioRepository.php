<?php

namespace App\Repositories;

use App\Models\Comentario;
use Illuminate\Database\Eloquent\Collection;

class ComentarioRepository
{
    public function obtenerTodos(): Collection
    {
        return Comentario::orderBy('fecha_creacion', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Comentario
    {
        return Comentario::find($id);
    }

    public function crear(array $datos): Comentario
    {
        return Comentario::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Comentario
    {
        $comentario = Comentario::find($id);
        if (!$comentario) return null;

        $comentario->update($datos);
        return $comentario->fresh();
    }

    public function eliminar(int $id): bool
    {
        $comentario = Comentario::find($id);
        if (!$comentario) return false;

        return (bool) $comentario->delete();
    }
}

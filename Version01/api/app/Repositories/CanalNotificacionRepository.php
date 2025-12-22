<?php

namespace App\Repositories;

use App\Models\CanalNotificacion;
use Illuminate\Database\Eloquent\Collection;

class CanalNotificacionRepository
{
    public function obtenerTodos(): Collection
    {
        return CanalNotificacion::orderBy('id_canal_notificacion', 'asc')->get();
    }

    public function obtenerPorId(int $id): ?CanalNotificacion
    {
        return CanalNotificacion::find($id);
    }

    public function crear(array $datos): CanalNotificacion
    {
        return CanalNotificacion::create($datos);
    }

    public function actualizar(int $id, array $datos): ?CanalNotificacion
    {
        $canal = CanalNotificacion::find($id);
        if (!$canal) return null;

        $canal->update($datos);
        return $canal->fresh();
    }

    public function eliminar(int $id): bool
    {
        $canal = CanalNotificacion::find($id);
        if (!$canal) return false;

        return (bool) $canal->delete();
    }
}

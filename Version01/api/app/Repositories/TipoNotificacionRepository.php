<?php

namespace App\Repositories;

use App\Models\TipoNotificacion;
use Illuminate\Database\Eloquent\Collection;

class TipoNotificacionRepository
{
    public function obtenerTodos(): Collection
    {
        return TipoNotificacion::orderBy('id_tipo_notificacion', 'asc')->get();
    }

    public function obtenerPorId(int $id): ?TipoNotificacion
    {
        return TipoNotificacion::find($id);
    }

    public function crear(array $datos): TipoNotificacion
    {
        return TipoNotificacion::create($datos);
    }

    public function actualizar(int $id, array $datos): ?TipoNotificacion
    {
        $tipo = TipoNotificacion::find($id);
        if (!$tipo) return null;

        $tipo->update($datos);
        return $tipo->fresh();
    }

    public function eliminar(int $id): bool
    {
        $tipo = TipoNotificacion::find($id);
        if (!$tipo) return false;

        return (bool) $tipo->delete();
    }
}

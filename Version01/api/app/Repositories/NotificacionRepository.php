<?php

namespace App\Repositories;

use App\Models\Notificacion;
use Illuminate\Database\Eloquent\Collection;

class NotificacionRepository
{
    public function obtenerTodas(): Collection
    {
        return Notificacion::orderBy('fecha_envío', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Notificacion
    {
        return Notificacion::find($id);
    }

    public function crear(array $datos): Notificacion
    {
        return Notificacion::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Notificacion
    {
        $notificacion = Notificacion::find($id);
        if (!$notificacion) return null;

        $notificacion->update($datos);
        return $notificacion->fresh();
    }

    public function eliminar(int $id): bool
    {
        $notificacion = Notificacion::find($id);
        if (!$notificacion) return false;

        return (bool) $notificacion->delete();
    }
}

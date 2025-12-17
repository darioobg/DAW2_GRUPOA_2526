<?php

namespace App\Repositories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Collection;

class ProyectoRepository
{
    public function obtenerTodos(): Collection
    {
        return Proyecto::orderBy('created_at', 'desc')->get();
    }

    public function crear(array $datos): Proyecto
    {
        return Proyecto::create($datos);
    }
}

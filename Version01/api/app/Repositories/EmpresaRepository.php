<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Collection;

class EmpresaRepository
{
    public function obtenerTodos(): Collection
    {
        return Empresa::orderBy('created_at', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?Empresa
    {
        return Empresa::find($id);
    }

    public function crear(array $datos): Empresa
    {
        return Empresa::create($datos);
    }

    public function actualizar(int $id, array $datos): ?Empresa
    {
        $empresa = Empresa::find($id);
        if (!$empresa) return null;

        $empresa->update($datos);
        return $empresa->fresh();
    }

    public function eliminar(int $id): bool
    {
        $empresa = Empresa::find($id);
        if (!$empresa) return false;

        return (bool) $empresa->delete();
    }
}

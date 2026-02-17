<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function obtenerTodos(): Collection
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    public function obtenerPorId(int $id): ?User
    {
        return User::find($id);
    }

    public function crear(array $datos): User
    {
        return User::create($datos);
    }

    public function actualizar(int $id, array $datos): ?User
    {
        $User = User::find($id);
        if (!$User) return null;

        $User->update($datos);
        return $User->fresh();
    }

    public function eliminar(int $id): bool
    {
        $User = User::find($id);
        if (!$User) return false;

        return (bool) $User->delete();
    }
}

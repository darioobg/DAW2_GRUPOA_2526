<?php

namespace App\Services;

use App\Models\Usuario;
use App\Repositories\UsuarioRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Exception;

class UsuarioService
{
    public function __construct(
        private UsuarioRepository $repo
    ) {}

    public function listar(): array
    {
        $usuarios = $this->repo->obtenerTodos();

        return $usuarios
            ->map(fn (Usuario $u) => $this->toViewModel($u))
            ->toArray();
    }

    public function obtener(int $id): array
    {
        $usuario = $this->repo->obtenerPorId($id);

        if (!$usuario) {
            throw new Exception('Usuario no encontrado.');
        }

        return $this->toViewModel($usuario);
    }

    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre es obligatorio.');
        }

        $apellidos = trim($datos['apellidos'] ?? '');
        if ($apellidos === '') {
            throw new Exception('Los apellidos son obligatorios.');
        }

        $email = trim($datos['email'] ?? '');
        if ($email === '') {
            throw new Exception('El email es obligatorio.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El email no tiene un formato válido.');
        }

        $password = (string)($datos['password'] ?? '');
        if (strlen($password) < 8) {
            throw new Exception('La contraseña debe tener al menos 8 caracteres.');
        }

        $activo = $datos['activo'] ?? true;
        if (!is_bool($activo) && !in_array($activo, [0, 1, '0', '1'], true)) {
            throw new Exception('El campo activo debe ser boolean.');
        }

        $nuevo = $this->repo->crear([
            'nombre'         => $nombre,
            'apellidos'      => $apellidos,
            'email'          => $email,
            'password'  => Hash::make($password),
            'fecha_registro' => $datos['fecha_registro'] ?? now()->toDateString(),
            'ultimoAcceso'  => $datos['ultimo_acceso'] ?? null,
            'activo'         => (bool)$activo,
        ]);

        return $this->toViewModel($nuevo);
    }

    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Usuario no encontrado.');
        }

        $payload = [];

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') throw new Exception('El nombre no puede estar vacío.');
            $payload['nombre'] = $nombre;
        }

        if (array_key_exists('apellidos', $datos)) {
            $apellidos = trim((string)$datos['apellidos']);
            if ($apellidos === '') throw new Exception('Los apellidos no pueden estar vacíos.');
            $payload['apellidos'] = $apellidos;
        }

        if (array_key_exists('email', $datos)) {
            $email = trim((string)$datos['email']);
            if ($email === '') throw new Exception('El email no puede estar vacío.');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El email no tiene un formato válido.');
            }
            $payload['email'] = $email;
        }

        if (array_key_exists('password', $datos)) {
            $password = (string)$datos['password'];
            if (strlen($password) < 8) {
                throw new Exception('La contraseña debe tener al menos 8 caracteres.');
            }
            $payload['password_hash'] = Hash::make($password);
        }

        if (array_key_exists('fecha_registro', $datos)) {
            $payload['fecha_registro'] = $this->parseDateOrThrow($datos['fecha_registro'], 'fecha_registro');
        }

        if (array_key_exists('ultimo_acceso', $datos)) {
            // puede ser null
            $payload['ultimo_acceso'] = $datos['ultimo_acceso'] === null
                ? null
                : $this->parseDateOrThrow($datos['ultimo_acceso'], 'ultimo_acceso');
        }

        if (array_key_exists('activo', $datos)) {
            $activo = $datos['activo'];
            if (!is_bool($activo) && !in_array($activo, [0, 1, '0', '1'], true)) {
                throw new Exception('El campo activo debe ser boolean.');
            }
            $payload['activo'] = (bool)$activo;
        }

        $editado = $this->repo->actualizar($id, $payload);
        if (!$editado) {
            throw new Exception('No se pudo actualizar el usuario.');
        }

        return $this->toViewModel($editado);
    }

    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Usuario no encontrado o no se pudo eliminar.');
        }
    }

    private function toViewModel(Usuario $u): array
    {
        return [
            'id'           => $u->id_usuario,
            'nombre'       => $u->nombre,
            'apellidos'    => $u->apellidos,
            'email'        => $u->email,
            'fechaRegistro'=> $u->fecha_registro?->toDateString(),
            'ultimoAcceso' => $u->ultimo_acceso?->toDateString(),
            'activo'       => (bool)$u->activo,
            'creadoHace'   => $u->created_at
                ? Carbon::parse($u->created_at)->diffForHumans()
                : null,
        ];
    }

    private function parseDateOrThrow($value, string $campo): string
    {
        if ($value === null || $value === '') {
            throw new Exception("El campo {$campo} es obligatorio.");
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable $e) {
            throw new Exception("El campo {$campo} no tiene un formato de fecha válido.");
        }
    }
}

<?php

namespace App\Services;

use App\Models\Empresa;
use App\Repositories\EmpresaRepository;
use Illuminate\Support\Carbon;
use Exception;

class EmpresaService
{
    public function __construct(
        private EmpresaRepository $repo
    ) {}

    /**
     * Lista empresas (ViewModel)
     */
    public function listar(): array
    {
        $empresas = $this->repo->obtenerTodos();

        return $empresas
            ->map(fn (Empresa $e) => $this->toViewModel($e))
            ->toArray();
    }

    /**
     * Obtiene una empresa por id (ViewModel)
     */
    public function obtener(int $id): array
    {
        $empresa = $this->repo->obtenerPorId($id);

        if (!$empresa) {
            throw new Exception('Empresa no encontrada.');
        }

        return $this->toViewModel($empresa);
    }

    /**
     * Crea una empresa con validación básica de negocio
     */
    public function crear(array $datos): array
    {
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre de la empresa es obligatorio.');
        }

        $activo = $datos['activo'] ?? true;
        if (!is_bool($activo) && !in_array($activo, [0, 1, '0', '1'], true)) {
            throw new Exception('El campo activo debe ser boolean.');
        }

        $nueva = $this->repo->crear([
            'nombre'      => $nombre,
            'cif_nif'     => $datos['cif_nif'],
            'direccion'   => $datos['direccion'] ?? null,
            'telefono'    => $datos['telefono'] ?? null,
            'fecha_alta'  => $datos['fecha_alta'] ?? now()->toDateString(),
            'activa'      => (bool) ($datos['activa'] ?? true),
        ]);

        return $this->toViewModel($nueva);
    }

    /**
     * Actualiza una empresa existente
     */
    public function actualizar(int $id, array $datos): array
    {
        $actual = $this->repo->obtenerPorId($id);
        if (!$actual) {
            throw new Exception('Empresa no encontrada.');
        }

        $payload = [];

        if (array_key_exists('nombre', $datos)) {
            $nombre = trim((string)$datos['nombre']);
            if ($nombre === '') throw new Exception('El nombre no puede estar vacío.');
            $payload['nombre'] = $nombre;
        }

        if (array_key_exists('descripcion', $datos)) {
            $payload['descripcion'] = $datos['descripcion']; // puede ser null
        }

        if (array_key_exists('fecha_creacion', $datos)) {
            $payload['fecha_creacion'] = $this->parseDateOrThrow($datos['fecha_creacion'], 'fecha_creacion');
        }

        if (array_key_exists('activo', $datos)) {
            $activo = $datos['activo'];
            if (!is_bool($activo) && !in_array($activo, [0, 1, '0', '1'], true)) {
                throw new Exception('El campo activo debe ser boolean.');
            }
            $payload['activo'] = (bool)$activo;
        }

        $editada = $this->repo->actualizar($id, $payload);
        if (!$editada) {
            throw new Exception('No se pudo actualizar la empresa.');
        }

        return $this->toViewModel($editada);
    }

    /**
     * Elimina una empresa
     */
    public function eliminar(int $id): void
    {
        $ok = $this->repo->eliminar($id);

        if (!$ok) {
            throw new Exception('Empresa no encontrada o no se pudo eliminar.');
        }
    }

    /**
     * ViewModel para frontend
     */
    private function toViewModel(Empresa $e): array
    {
        return [
            'id'            => $e->id,
            'nombre'        => $e->nombre,
            'descripcion'   => $e->descripcion,
            'fechaCreacion' => $e->fecha_creacion?->toDateString(),
            'activo'        => (bool)$e->activo,
            'creadoHace'    => $e->created_at
                ? Carbon::parse($e->created_at)->diffForHumans()
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

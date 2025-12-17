<?php

namespace App\Services;

use App\Repositories\ProyectoRepository;
use App\Models\Proyecto;
use Illuminate\Support\Carbon;
use Exception;

class ProyectoService
{
    public function __construct(
        private ProyectoRepository $repo
    ) {}

    /**
     * Devuelve todos los proyectos ya formateados para el frontend (ViewModel)
     */
    public function listar(): array
    {
        $proyectos = $this->repo->obtenerTodos();

        return $proyectos->map(function (Proyecto $p) {
            return $this->toViewModel($p);
        })->toArray();
    }

    /**
     * Crea un nuevo proyecto con validación básica.
     */
    public function crear(array $datos): array
    {
        // Validación mínima de negocio
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            throw new Exception('El nombre del proyecto es obligatorio.');
        }

        $nuevo = $this->repo->crear([
            'nombre'        => $nombre,
            'descripcion'   => $datos['descripcion']   ?? null,
            'color_fondo'   => $datos['color_fondo']   ?? null,
            'imagen_fondo'  => $datos['imagen_fondo']  ?? null,
        ]);

        return $this->toViewModel($nuevo);
    }

    private function toViewModel(Proyecto $p): array
    {
        return [
            'id'          => $p->id,
            'nombre'      => $p->nombre,
            'descripcion' => $p->descripcion,
            'color'       => $p->color_fondo,
            'imagen'      => $p->imagen_fondo,
            'creadoHace'  => $p->created_at
                ? Carbon::parse($p->created_at)->diffForHumans()
                : null,
        ];
    }
}

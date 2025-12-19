<?php

namespace App\Services;

use App\Repositories\ComentarioRepository;
use App\Models\Comentario;
use Illuminate\Support\Carbon;
use Exception;

class ComentarioService
{
    public function __construct(
        private ComentarioRepository $repo
    ) {}

    /**
     * Devuelve todos los comentarios formateados para el frontend.
     */
    public function listar(): array
    {
        $comentarios = $this->repo->obtenerTodos();

        return $comentarios->map(function (Comentario $c) {
            return $this->toViewModel($c);
        })->toArray();
    }

    /**
     * Crea un nuevo comentario con validación básica.
     */
    public function crear(array $datos): array
    {
        $texto = trim($datos['texto'] ?? '');
        if ($texto === '') {
            throw new Exception('El texto del comentario es obligatorio.');
        }

        $nuevo = $this->repo->crear([
            'id_tarea'       => $datos['id_tarea']     ?? throw new Exception('Falta id_tarea.'),
            'id_usuario'     => $datos['id_usuario']   ?? throw new Exception('Falta id_usuario.'),
            'texto'          => $texto,
            'fecha_creacion' => $datos['fecha_creacion'] ?? Carbon::now(),
            'fecha_edicion'  => $datos['fecha_edicion']  ?? null,
        ]);

        return $this->toViewModel($nuevo);
    }

    private function toViewModel(Comentario $c): array
    {
        return [
            'id'         => $c->id_comentario,
            'tareaId'    => $c->id_tarea,
            'usuarioId'  => $c->id_usuario,
            'texto'      => $c->texto,
            'creadoHace' => $c->fecha_creacion
                ? Carbon::parse($c->fecha_creacion)->diffForHumans()
                : null,
            'editadoHace' => $c->fecha_edicion
                ? Carbon::parse($c->fecha_edicion)->diffForHumans()
                : null,
        ];
    }
}

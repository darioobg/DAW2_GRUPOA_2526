<?php

namespace App\Http\Controllers;

use App\Services\EstadoTareaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EstadoTareaController extends Controller
{
    public function __construct(
        private EstadoTareaService $service
    ) {}

    /**
     * GET /api/proyectos/{idProyecto}/columnas
     * Listar columnas de un proyecto
     */
    public function index(int $idProyecto): JsonResponse
    {
        try {
            return response()->json(
                $this->service->listarPorProyecto($idProyecto)
            );
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/proyectos/{idProyecto}/columnas
     * Crear nueva columna dentro de un proyecto
     */
    public function store(Request $request, int $idProyecto): JsonResponse
    {
        try {
            $data = $request->all();
            $data['id_proyecto'] = $idProyecto;

            $columna = $this->service->crear($data);

            return response()->json($columna, 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * PUT /api/columnas/{id}
     * Actualizar nombre u orden de una columna
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $columna = $this->service->actualizar($id, $request->all());

            return response()->json($columna);
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $status = str_contains(mb_strtolower($msg), 'no encontrada') ? 404 : 422;

            return response()->json([
                'message' => $msg
            ], $status);
        }
    }

    /**
     * DELETE /api/columnas/{id}
     * Eliminar columna
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->eliminar($id);

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProyectoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function __construct(
        private ProyectoService $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->listar());
    }

    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->service->obtener($id));
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        
        try {
            $proyecto = $this->service->crear($request->all());
            return response()->json($proyecto, 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $proyecto = $this->service->actualizar($id, $request->all());
            return response()->json($proyecto);
        } catch (\Throwable $e) {
            // Si el service lanza "no encontrado", devolvemos 404, si no 422
            $msg = $e->getMessage();
            $status = str_contains(mb_strtolower($msg), 'no encontrado') ? 404 : 422;

            return response()->json(['message' => $msg], $status);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->eliminar($id);
            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CanalNotificacionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CanalNotificacionController extends Controller
{
    public function __construct(
        private CanalNotificacionService $service
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
            $canal = $this->service->crear($request->all());
            return response()->json($canal, 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $canal = $this->service->actualizar($id, $request->all());
            return response()->json($canal);
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $status = str_contains(mb_strtolower($msg), 'no encontrado')
                ? 404
                : 422;

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

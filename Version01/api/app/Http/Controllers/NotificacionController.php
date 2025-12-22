<?php

namespace App\Http\Controllers;

use App\Services\NotificacionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function __construct(
        private NotificacionService $service
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
            $notificacion = $this->service->crear($request->all());
            return response()->json($notificacion, 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $notificacion = $this->service->actualizar($id, $request->all());
            return response()->json($notificacion);
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $status = str_contains(mb_strtolower($msg), 'no encontrada')
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

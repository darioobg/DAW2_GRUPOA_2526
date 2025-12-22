<?php

namespace App\Http\Controllers;

use App\Services\UsuarioEmpresaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioEmpresaController extends Controller
{
    public function __construct(
        private UsuarioEmpresaService $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->listar());
    }

    public function show(int $idUsuario, int $idEmpresa): JsonResponse
    {
        try {
            return response()->json($this->service->obtener($idUsuario, $idEmpresa));
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $registro = $this->service->crear($request->all());
            return response()->json($registro, 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $idUsuario, int $idEmpresa): JsonResponse
    {
        try {
            $registro = $this->service->actualizar($idUsuario, $idEmpresa, $request->all());
            return response()->json($registro);
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $status = str_contains(mb_strtolower($msg), 'no encontrada') ? 404 : 422;

            return response()->json(['message' => $msg], $status);
        }
    }

    public function destroy(int $idUsuario, int $idEmpresa): JsonResponse
    {
        try {
            $this->service->eliminar($idUsuario, $idEmpresa);
            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}

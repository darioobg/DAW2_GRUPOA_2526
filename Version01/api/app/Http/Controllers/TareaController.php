<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TareaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function __construct(
        private TareaService $service
    ) {}

    public function index(): JsonResponse
    {
        $data = $this->service->listar();
        // dd($data[0]);

        //   dd($data);
        // echo '<pre>';
        // var_dump($this->service->listar());
        // exit;

        return response()->json($data);
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
            $tarea = $this->service->crear($request->all());
            return response()->json($tarea, 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $tarea = $this->service->actualizar($id, $request->all());
            return response()->json($tarea);
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

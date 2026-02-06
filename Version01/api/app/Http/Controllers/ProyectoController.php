<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProyectoFiltroRequest;
use App\Http\Requests\ProyectoRequest;
use App\Services\ProyectoService;
use Illuminate\Http\JsonResponse;

class ProyectoController extends Controller
{
    public function __construct(
        private ProyectoService $service
    ) {}

    public function index(ProyectoFiltroRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $proyectos = $this->service->listar($filters);
        return response()->json($proyectos, 200);
    }

    public function show(int $id): JsonResponse
    {
        $proyecto = $this->service->obtener($id);
        return response()->json($proyecto, 200);
    }

    public function store(ProyectoRequest $request): JsonResponse
    {
        $proyecto = $this->service->crear($request->validated());
        return response()->json($proyecto, 201);
    }

    public function update(ProyectoRequest $request, int $id): JsonResponse
    {
        $proyecto = $this->service->actualizar($id, $request->validated());
        return response()->json($proyecto, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->eliminar($id);
        return response()->json(['message' => 'Proyecto eliminado correctamente.'], 200);
    }
}

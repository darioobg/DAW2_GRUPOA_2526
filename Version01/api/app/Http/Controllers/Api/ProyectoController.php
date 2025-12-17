<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProyectoService;
use Illuminate\Http\Request;
use Throwable;

class ProyectoController extends Controller
{
    public function __construct(
        private ProyectoService $service
    ) {}

    public function index()
    {
        try {
            return response()->json([
                'ok'   => true,
                'data' => $this->service->listar(),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $proyecto = $this->service->crear($request->all());

            return response()->json([
                'ok'   => true,
                'data' => $proyecto,
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}

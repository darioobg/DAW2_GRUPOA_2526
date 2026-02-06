<?php

namespace App\Exceptions;

use App\Exceptions\DomainException;
use App\Exceptions\ErrorCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            // 404 - Modelo no encontrado
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => ErrorCode::PROYECTO_NO_ENCONTRADO,
                        'message' => 'Recurso no encontrado'
                    ]
                ], 404);
            }

            // 404 - Endpoint no existe
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => ErrorCode::ENDPOINT_NO_ENCONTRADO,
                        'message' => 'Endpoint no encontrado'
                    ]
                ], 404);
            }

            // 400 - Regla de negocio
            if ($exception instanceof DomainException) {
                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => $exception->getErrorCode(),
                        'message' => $exception->getMessage()
                    ]
                ], 400);
            }

            // 500 - Error interno
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => ErrorCode::ERROR_INTERNO,
                    'message' => 'Error interno del servidor'
                ]
            ], 500);
        }

        return parent::render($request, $exception);
    }
}

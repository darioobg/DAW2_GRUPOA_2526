<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Método Login
    public function login(Request $request)
    {
        // 1. Validar datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Buscar usuario
        $user = User::where('email', $request->email)->first();

        // 3. Comprobar credenciales
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        // 4. Generar Token
        // 'api-token' es el nombre interno del token
        $token = $user->createToken('api-token')->plainTextToken;
        $equipos = $user
            ->usuarioEquipos()
            ->with(['equipo', 'rol_equipo'])
            ->get()
            ->map(function ($item) {
                return [
                    'idEquipo' => $item->equipo->id,
                    'nombreEquipo' => $item->equipo->nombre,
                    'rol' => $item->rol_equipo->nombre,
                    'activo' => $item->activo
                ];
            });
        // 5. Devolver respuesta JSON
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'equipos' => $equipos,
        ]);
    }
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), //  AQUÍ
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Usuario creado correctamente'
    ]);
}
    // Método Logout
    public function logout(Request $request)
    {
        // Revocar el token actual que se usó en la petición
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth\Logout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/auth/logout",
     *     operationId="Logout",
     *     tags={"Autenticación"},
     *     summary="Cerrar sesión",
     *     description="Crerra la sesión del usuario y elimina el token de autorización",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(response=200, description="Sesión cerrada"),
     *     @OA\Response(response=401, description="El usuario no está verificado"),
     *     @OA\Response(response=500, description="Error en el servidor, Token inválido"),
     * )
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                "success" => 0,
                "message" => "El usuario no está verificado",
            ], 401);
        }

        $user->tokens()->delete();

        return response()->json([
            "success" => 1,
            "message" => "Sesión cerrada",
        ], 200);
    }
}

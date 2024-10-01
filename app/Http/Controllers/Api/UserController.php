<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use App\Models\User;

class UserController
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     operationId="Usuarios",
     *     tags={"Root"},
     *     summary="Lista de usuarios",
     *     description="Muestra una lista de todos los usuarios",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(response=200, description="Lista de usuarios"),
     *     @OA\Response(response=401, description="El usuario no está verificado"),
     *     @OA\Response(response=500, description="Error en el servidor, Token inválido"),
     * )
     */
    public function index()
    {
        User::all();

        return response()->json([
            'success' => 1,
            'message' => 'Lista de usuarios',
            'data' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */


    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
        // Código 204 indica que la solicitud fue exitosa pero no hay contenido
    }

    /**
     * @OA\Get(
     *     path="/api/auth/profile",
     *     operationId="getProfile",
     *     tags={"Autenticación"},
     *     summary="Perfil de usuario",
     *     description="Muestra toda la información del usuario",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(response=200, description="Información del usuario"),
     *     @OA\Response(response=401, description="El usuario no está verificado"),
     *     @OA\Response(response=500, description="Error en el servidor, Token inválido"),
     * )
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            "success" => 1,
            "message" => "Información del usuario",
            "datum" => $user,
        ], 200);
    }
}

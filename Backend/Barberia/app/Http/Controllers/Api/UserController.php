<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use App\Models\User;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar solicitud
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'celular' => 'required|integer|digits:10',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'celular' => $validatedData['celular'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json($user, 201);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:250',
            'celular' => 'sometimes|integer|digits:10',
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);

        // Actualiza  usuario
        $user->update(array_filter($validatedData, fn($value) => !is_null($value)));
        // Devuelve una respuesta
        return response()->json($user);
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
     *     @OA\Response(response=401, description="No autorizado"),
     *     @OA\Response(response=500, description="Error en el servidor, Token inválido"),
     * )
     *
     * @OA\SecurityScheme(
     *     securityScheme="ApiKeyAuth",
     *     type="apiKey",
     *     in="header",
     *     name="Authorization",
     *     description="Ingresar el token de autorización",
     *     scheme="bearer",
     *     bearerFormat="Bearer {token}",
     * )
     */
    public function profile(Request $request)
    {
        $userData = $request->user();

        return response()->json([
            "success" => 1,
            "message" => "Información del usuario",
            "datum" => $userData,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/logout",
     *     operationId="Logout",
     *     tags={"Autenticación"},
     *     summary="Cerrar sesión",
     *     description="Crerra la sesión del usuario y elimina el token de autorización",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(response=200, description="Sesión cerrada"),
     *     @OA\Response(response=401, description="No autorizado"),
     *     @OA\Response(response=500, description="Error en el servidor, Token inválido"),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "success" => 1,
            "message" => "Sesión cerrada",
        ], 200);
    }
}

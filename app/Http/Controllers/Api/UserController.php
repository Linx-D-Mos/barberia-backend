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
     *     tags={"Usuarios"},
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

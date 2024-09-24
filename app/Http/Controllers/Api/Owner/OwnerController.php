<?php

namespace App\Http\Controllers\Api\Owner;

use App\Models\Profile;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OwnerController
{
    /**
     * @OA\Post(
     *     path="/api/owner/create_barber",
     *     operationId="CreateBarber",
     *     tags={"Dueno"},
     *     summary="Crear barbero",
     *     description="Crea un nuevo barbero en la aplicación",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone", "barbershop_id"},
     *               @OA\Property(property="name", type="string", example=""),
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="phone", type="number", example=""),
     *               @OA\Property(property="barbershop_id", type="number", example=""),
     *            ),
     *        ),
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone", "barbershop_id"},
     *               @OA\Property(property="name", type="string", example=""),
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="phone", type="number", example=""),
     *               @OA\Property(property="barbershop_id", type="number", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(response=200, description="Barbero registrado correctamente"),
     *      @OA\Response(response=400, description="Solicitud incorrecta"),
     *      @OA\Response(response=401, description="Debe verificar su correo electrónico para continuar."),
     *      @OA\Response(response=404, description="Recurso no encontrado"),
     *      @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
     public function createBarber(Request $request) 
     {

        // Validaciones
        $validatedData = Validator::make( $request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'barbershop_id' => 'required|numeric|exists:barbershops,id',
        ]);

        // si falla la validación
        if ($validatedData->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        // Usuario
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            // lo siguiente no debería ir aquí, pero por fines de prueba lo dejé
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            "password" => bcrypt($request->phone),
        ]);

        // Perfil
        Profile::create([
            'user_id' => User::where('email', $request->email)->first()->id,
            'role_id' => Role::where('name', 'barber')->first()->id,
            'barbershop_id' => $request->barbershop_id,
        ]);

        // Respuesta
        return response()->json([
            'success' => 1,
            'message' => 'Barbero registrado correctamente',
        ], 200);
     }


     public function registrarSecretary(Request $request) {

        // Validaciones
        $validatedData = Validator::make( $request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
        ]);

        // si falla la validación
        if ($validatedData->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        // Usuario
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => bcrypt($request->phone),
        ]);

        // Perfil
        Profile::create([
            'user_id' => User::where('email', $request->email)->first()->id,
            'role_id' => Role::where('name', 'sercretary')->first()->id,
        ]);

        // Respuesta
        return response()->json([
            'success' => 1,
            'message' => 'Secretari@ registrado correctamente',
        ], 200);
     }
}

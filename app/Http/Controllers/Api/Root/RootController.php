<?php

namespace App\Http\Controllers\Api\Root;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\String\b;

class RootController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/root/create_owner",
     *     operationId="CreateOwner",
     *     tags={"Root"},
     *     summary="Crear propietario",
     *     description="Crea un nuevo propietario en la aplicación",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone"},
     *               @OA\Property(property="name", type="string", example=""),
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="phone", type="number", example=""),
     *            ),
     *        ),
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone"},
     *               @OA\Property(property="name", type="string", example=""),
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="phone", type="number", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(response=200, description="Propietario registrado correctamente"),
     *      @OA\Response(response=400, description="Solicitud incorrecta"),
     *      @OA\Response(response=401, description="Debe verificar su correo electrónico para continuar."),
     *      @OA\Response(response=404, description="Recurso no encontrado"),
     *      @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function createOwner(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            'photo' => 'https://barber-connect-images.s3.us-east-2.amazonaws.com/default/default.jpg',
            // lo siguiente no debería ir aquí, pero por fines de prueba lo dejé
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            "password" => bcrypt($request->phone),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'role_id' => Role::where('name', 'owner')->first()->id,
        ]);

        // Enviar el correo al propietario (pendiente)

        return response()->json([
            'success' => 1,
            'message' => 'Usuario registrado correctamente',
        ], 200);
    }
}

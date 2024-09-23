<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     operationId="Register",
     *     tags={"Autenticación"},
     *     summary="Registrarse",
     *     description="Si el usuario no está registrado, puede registrarse en la aplicación con sus datos personales, al hacer esto se genera un token para él, que le permite acceder a las rutas protegidas",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone", "password", "password_confirmation"},
     *               @OA\Property(property="name", type="string", example=""),
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="phone", type="number", example=""),
     *               @OA\Property(property="password", type="string", example=""),
     *               @OA\Property(property="password_confirmation", type="string", example="")
     *            ),
     *        ),
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone", "password", "password_confirmation"},
     *               @OA\Property(property="name", type="string", example=""),
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="phone", type="number", example=""),
     *               @OA\Property(property="password", type="string", example=""),
     *               @OA\Property(property="password_confirmation", type="string", example="")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(response=200, description="Usuario registrado correctamente"),
     *      @OA\Response(response=400, description="Solicitud incorrecta"),
     *      @OA\Response(response=401, description="El correo electrónico o el teléfono ya están registrados"),
     *      @OA\Response(response=404, description="Recurso no encontrado"),
     *      @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function register(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Usuario
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => bcrypt($request->password),
        ]);

        // Vincular el usuario con el rol correspondiente en el perfil
        Profile::create([
            'user_id' => User::where('email', $request->email)->first()->id,
            'role_id' => Role::where('name', 'client')->first()->id,
        ]);

        $user = User::where('email', $request->email)->first();

        // Enviar el código de verificación
        $user->sendVerificationCode();

        // Crear el token de acceso
        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'success' => 1,
            'message' => 'A su correo electrónico se le ha enviado un código de verificación',
            'token' => $token,
        ], 200);
    }
}

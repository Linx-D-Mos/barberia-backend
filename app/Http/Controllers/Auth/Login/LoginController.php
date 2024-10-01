<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="Login",
     *     tags={"Autenticación"},
     *     summary="Iniciar sesión",
     *     description="Los usuarios inician sesión en la aplicación y se genera un token para ellos, que les permite acceder a las rutas protegidas",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="password", type="string", example=""),
     *            ),
     *        ),
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="string", example=""),
     *               @OA\Property(property="password", type="string", example=""),
     *            ),
     *        ),
     *    ),
     *    @OA\Response(response=200, description="Inicio de sesión correcto"),
     *    @OA\Response(response=400, description="Solictud incorrecta"),
     *    @OA\Response(response=401, description="El correo electrónico no está registrado"),
     *    @OA\Response(response=402, description="Contraseña incorrecta"),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function login(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            "email" => "required|email|string",
            "password" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $request['email'] = strtolower($request->email);

        // Comprobar si el correo existe
        $user = User::where("email", $request->email)->first();

        if ($user == null) {
            return response()->json([
                "success" => 0,
                "message" => "El correo electrónico no está registrado",
            ], 401);
        }

        // El correo existe
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "success" => 0,
                "message" => "Contraseña incorrecta",
            ], 402);
        }

        // El usuario no puede tener más de un token activo
        $user->tokens()->delete();

        // verificar si el usuario está bloqueado
        if ($user->status == 'BLOQUEADO') {
            return response()->json([
                'success' => 0,
                'message' => 'No puedes ingresar al sistema. Tu cuenta está bloqueada.'
            ], 403);
        }

        // verificar si la berberia a la que pertenece un barbero está bloqueada
        if ($user->profile->role->name == 'barber') {
            $barbershop = $user->barbershop;
            if ($barbershop->status == 'BLOQUEADA') {
                return response()->json([
                    'success' => 0,
                    'message' => 'No puedes ingresar al sistema. La barbería está bloqueada.'
                ], 403);
            }
        }

        // rol del perfil del usuario
        $role = $user->profile->role;

        $token = $user->createToken($request->email, [$role->name])->plainTextToken;

        return response()->json([
            'success' => 1,
            "message" => "Inicio de sesión correcto",
            'role' => $role->name,
            "token" => $token,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Auth\ResetPassword;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/send_reset_password_code",
     *     operationId="sendResetPasswordCode",
     *     tags={"Autenticación"},
     *     summary="Enviar código de restablecimiento de contraseña",
     *     description="Envía un código de restablecimiento de contraseña al correo electrónico del usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email"},
     *               @OA\Property(property="email", type="string", format="email", example=""),
     *            ),
     *         ),
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"email"},
     *               @OA\Property(property="email", type="string", format="email", example=""),
     *            ),
     *         ),
     *    ),
     *    @OA\Response(response=200, description="Código de restablecimiento de contraseña enviado correctamente"),
     *    @OA\Response(response=400, description="Correo electrónico no encontrado"),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function sendResetPasswordCode(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        // Enviar el código de restablecimiento de contraseña
        $user->sendResetPasswordCode($request->email);

        return response()->json([
            'success' => 1,
            'message' => 'Código de restablecimiento de contraseña enviado correctamente',
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/verify_reset_password_code",
     *     operationId="verifyResetPasswordCode",
     *     tags={"Autenticación"},
     *     summary="Verificar código de restablecimiento de contraseña",
     *     description="Verifica el código de restablecimiento de contraseña del usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "reset_password_code"},
     *               @OA\Property(property="email", type="string", format="email", example=""),
     *               @OA\Property(property="reset_password_code", type="number", example=""),
     *            ),
     *         ),
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "reset_password_code"},
     *               @OA\Property(property="email", type="string", format="email", example=""),
     *               @OA\Property(property="reset_password_code", type="number", example=""),
     *            ),
     *         ),
     *    ),
     *    @OA\Response(response=200, description="Código de restablecimiento de contraseña verificado correctamente"),
     *    @OA\Response(response=400, description="Código de restablecimiento de contraseña incorrecto"),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function verifyResetPasswordCode(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'reset_password_code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        // Verificar el código de restablecimiento de contraseña
        if (!$user->verifyResetPasswordCode($request->email, $request->reset_password_code)) {
            return response()->json([
                'success' => 0,
                'message' => 'Código de restablecimiento de contraseña incorrecto',
            ], 400);
        }

        // Si el correo electrónico no está verificado, se verifica automáticamente
        if (!$user->hasVerifiedEmail()) {
            $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();
        }

        // Eliminar los tokens de acceso existentes
        $user->tokens()->delete();

        // Crear un token de acceso
        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            'success' => 1,
            'message' => 'Código de restablecimiento de contraseña verificado correctamente',
            'token' => $token,
        ], 200);
    }
}

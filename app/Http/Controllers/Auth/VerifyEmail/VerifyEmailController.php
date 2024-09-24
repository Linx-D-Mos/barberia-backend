<?php

namespace App\Http\Controllers\Auth\VerifyEmail;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifyEmailController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/verify_email",
     *     operationId="verifyEmail",
     *     tags={"Autenticación"},
     *     summary="Verificar correo electrónico",
     *     description="Verifica el correo electrónico del usuario",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"code"},
     *               @OA\Property(property="code", type="number", example=""),
     *            ),
     *         ),
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"code"},
     *               @OA\Property(property="code", type="number", example=""),
     *            ),
     *         ),
     *    ),
     *    @OA\Response(response=200, description="Correo electrónico verificado correctamente"),
     *    @OA\Response(response=400, description="Código de verificación incorrecto"),
     *    @OA\Response(response=401, description="Debe verificar su correo electrónico para continuar."),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function verifyEmail(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric|exists:codes,code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        // Verificar el código de verificación
        if (!$user->verifyCode($request->code)) {
            return response()->json([
                'success' => 0,
                'message' => 'Código de verificación incorrecto',
            ], 400);
        }

        // Actualizar el estado de verificación del usuario
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();

        return response()->json([
            'success' => 1,
            'message' => 'Su correo electrónico ha sido verificado correctamente',
        ], 200);
    }
}

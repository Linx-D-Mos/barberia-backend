<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ClientController
{
    // Un cliente al registrarse debe elegir a que peluquería se va a afiliar
    /**
     * @OA\Put(
     *     path="/api/client/barbershop_affiliate",
     *     operationId="barbershopAffiliate",
     *     tags={"Cliente"},
     *     summary="Afiliarse a una peluquería",
     *     description="Un cliente al registrarse debe elegir a qué peluquería se va a afiliar",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"barbershop_id"},
     *               @OA\Property(property="barbershop_id", type="number", example=""),
     *            ),
     *         ),
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"barbershop_id"},
     *               @OA\Property(property="barbershop_id", type="number", example=""),
     *            ),
     *         ),
     *    ),
     *    @OA\Response(response=200, description="Afiliación a la peluquería exitosa"),
     *    @OA\Response(response=400, description="Solictud incorrecta"),
     *    @OA\Response(response=401, description="Debe verificar su correo electrónico para continuar."),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function barbershopAffiliate(Request $request)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'barbershop_id' => 'required|numeric|exists:barbershops,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user_id = $request->user()->id;

        // Actualizar el perfil del usuario
        Profile::where('user_id', $user_id)->update([
            'barbershop_id' => $request->barbershop_id,
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Afiliación a la peluquería exitosa',
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/client/profile",
     *     tags={"Cliente"},
     *     summary="Obtener el perfil del cliente",
     *     description="Retorna el perfil del cliente autenticado, incluyendo información del usuario, rol y barbería.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Perfil del cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Perfil del cliente"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object"),
     *                 @OA\Property(property="role", type="object"),
     *                 @OA\Property(property="barbershop", type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró el perfil del cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="integer", example=0),
     *             @OA\Property(property="message", type="string", example="No se encontró el perfil del cliente")
     *         )
     *     ),
     * )
     */
    public function perfil(Request $request)
    {
        $clientProfile = Profile::with('user', 'role', 'barbershop')
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$clientProfile) {
            return response()->json([
                'success' => 0,
                'message' => 'No se encontró el perfil del cliente'
            ], 404);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Perfil del cliente',
            'data' => $clientProfile
        ]);
    }
}

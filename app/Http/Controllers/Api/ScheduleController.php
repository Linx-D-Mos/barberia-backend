<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    
    /**
     * @OA\Post(
     *     path="/api/client/schedule_barbershop",
     *     operationId="scheduleBarbershop",
     *     tags={"Cliente"},
     *     summary="Obtener los horarios de la barbería",
     *     description="Obtener los horarios de la barbería de un cliente autenticado",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Horarios de la barbería",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                property="message",
     *                type="string",
     *                example="Horarios de la barbería"
     *             ),
     *             @OA\Property(
     *                 property="schedules",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     description="Schedule object"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function scheduleBarbershop(Request $request)
    {
        $barbershop = $request->user()->profile->barbershop;

        return response()->json([
            'success' => 1,
            'message' => 'Horarios de la barbería',
            'schedules' => $barbershop->schedules()->orderBy('id')->get(),
        ], 200);
    }
}

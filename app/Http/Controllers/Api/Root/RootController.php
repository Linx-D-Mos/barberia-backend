<?php

namespace App\Http\Controllers\Api\Root;

use App\Http\Controllers\Controller;
use App\Models\Barbershop;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        try {
            DB::beginTransaction();

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

            DB::commit();
            
            // Enviar el correo al propietario (pendiente)
    
            return response()->json([
                'success' => 1,
                'message' => 'Propietario registrado correctamente',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => 0,
                'message' => 'Error al registrar el propietario',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * @OA\Get(
     *     path="/api/root/owners",
     *     operationId="ShowOwners",
     *     tags={"Root"},
     *     summary="Ver propietarios",
     *     description="Muestra todos los propietarios registrados en la aplicación",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(response=200, description="Listado de propietarios"),
     *     @OA\Response(response=404, description="Recurso no encontrado"),
     * )
     */
    public function showOwners()
    {
        $owners = User::whereHas('profile', function ($query) {
            $query->where('role_id', Role::where('name', 'owner')->first()->id);
        })->get();

        return response()->json([
            'success' => 1,
            'message' => 'Listado de propietarios',
            'data' => $owners,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/root/barbershops/{barbershop}/block",
     *     operationId="BlockBarbershop",
     *     tags={"Root"},
     *     summary="Bloquear barbería",
     *     description="Bloquea una barbería en la aplicación",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="barbershop",
     *         in="path",
     *         description="ID de la barbería",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Barbería bloqueada correctamente"),
     *     @OA\Response(response=404, description="Barbería no encontrada"),
     * )
     */
    public function blockBarbershop(Request $request, int $barbershop_id)
    {
        $barbershop = Barbershop::find($barbershop_id);

        if (!$barbershop) {
            return response()->json([
                'success' => 0,
                'message' => 'Barbería no encontrada',
            ], 404);
        }

        $barbershop->status = 'BLOQUEADA';
        $barbershop->save();

        return response()->json([
            'success' => 1,
            'message' => 'Barbería bloqueada correctamente',
            'datum' => $barbershop,
        ], 200);
    }


    /**
     * @OA\Put(
     *     path="/api/root/barbershops/{barbershop}/unblock",
     *     operationId="UnblockBarbershop",
     *     tags={"Root"},
     *     summary="Desbloquear barbería",
     *     description="Desbloquea una barbería en la aplicación",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="barbershop",
     *         in="path",
     *         description="ID de la barbería",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Barbería desbloqueada correctamente"),
     *     @OA\Response(response=404, description="Barbería no encontrada"),
     * )
     */
    public function unblockBarbershop(Request $request, int $barbershop_id)
    {
        $barbershop = Barbershop::find($barbershop_id);

        if (!$barbershop) {
            return response()->json([
                'success' => 0,
                'message' => 'Barbería no encontrada',
            ], 404);
        }

        $barbershop->status = 'ACTIVA';
        $barbershop->save();

        return response()->json([
            'success' => 1,
            'message' => 'Barbería desbloqueada correctamente',
            'datum' => $barbershop,
        ], 200);
    }
}

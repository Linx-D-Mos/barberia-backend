<?php

namespace App\Http\Controllers\Api\Owner;

use App\Models\Barbershop;
use App\Models\Profile;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OwnerController
{
    /**
     * @OA\Post(
     *     path="/api/owner/barbershops/{barbershop}/create_barber",
     *     operationId="CreateBarber",
     *     tags={"Dueño"},
     *     summary="Crear barbero",
     *     description="Crea un nuevo barbero en la aplicación",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="barbershop",
     *         in="path",
     *         required=true,
     *         description="ID de la barbería",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone"},
     *               @OA\Property(property="name", type="string", example="John Doe"),
     *               @OA\Property(property="email", type="string", example="john@example.com"),
     *               @OA\Property(property="phone", type="string", example="1234567890"),
     *               @OA\Property(property="nickname", type="string", example="Johnny"),
     *               @OA\Property(property="birth", type="string", format="date", example="1990-01-01"),
     *            ),
     *        ),
     *    ),
     *    @OA\Response(response=200, description="Barbero registrado correctamente"),
     *    @OA\Response(response=400, description="Solicitud incorrecta"),
     *    @OA\Response(response=401, description="No autorizado"),
     *    @OA\Response(response=403, description="Prohibido"),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación"),
     * )
     */
    public function createBarber(Request $request, int $barbershop_id)
    {

        // Validaciones
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'nickname' => 'nullable|string|max:50',
            'birth' => 'nullable|date',
        ]);

        // si falla la validación
        if ($validatedData->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Usuario
            $user = User::create($request->all() + [
                'photo' => 'https://barber-connect-images.s3.us-east-2.amazonaws.com/default/default.jpg',
                // lo siguiente no debería ir aquí, pero por fines de prueba lo dejé
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt($request->phone),
            ]);

            // Perfil
            Profile::create([
                'user_id' => $user->id,
                'role_id' => Role::where('name', 'barber')->first()->id,
                'barbershop_id' => $barbershop_id,
            ]);

            DB::commit();

            // Respuesta
            return response()->json([
                'success' => 1,
                'message' => 'Barbero registrado correctamente',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => 0,
                'message' => 'Error al registrar el barbero',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/owner/barbershops",
     *     operationId="getMyBarbershops",
     *     tags={"Dueño"},
     *     summary="Mis barberias",
     *     description="Muestra todas las barberias del dueño",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(response=200, description="Barberias del dueño obtenidas correctamente"),
     *     @OA\Response(response=401, description="El usuario no está verificado"),
     *     @OA\Response(response=500, description="Error en el servidor, Token inválido"),
     * )
     */
    public function myBarbershops(Request $request)
    {
        return response()->json([
            'success' => 1,
            'message' => 'Barberias del dueño obtenidas correctamente',
            'barbershops' => $request->user()->barbershops,
        ], 200);
    }

    public function registrarSecretary(Request $request)
    {

        // Validaciones
        $validatedData = Validator::make($request->all(), [
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

    //dos funciones para actualizar datos y otra para ver servicios
    /*public function actualizaBarbero(Request $request, $id)
    {
        // Validar solicitud
        $validatedData = Validator::make($request->all(), [
            'name' => 'string|max:250',
            'email' => 'email|max:255|unique:users,email',
            'phone' => 'numeric|digits:10|unique:users,phone',
        ]);

        if($validatedData->fails()){
            return response()->json([
                'success' => 0,
                'message' => 'Error de validacion, verifique los campos',
                'error' => $validatedData->errors()
            ],422);
        }

        $user = User::find($id);

        // Comprobar si el barbero está registrado
        if (!$user) {
            return response()->json(['success' => 0, 'message' => 'Barbero no encontrado'], 404);
        }

        // Actualiza los datos del barbero
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];

        $user->save();

        return response()->json([
            'success' => 1,
            'message' => 'Datos del barbero actualizados correctamente',
        ], 200);
    }

    public function actualizarSecretary(Request $request, $id)
    {
        // Validar solicitud
        $validatedData = Validator::make($request->all(), [
            'name' => 'string|max:250',
            'email' => 'email|max:255|unique:users,email',
            'phone' => 'numeric|digits:10|unique:users,phone',
        ]);

        if($validatedData->fails()){
            return response()->json([
                'success' => 0,
                'message' => 'Error de validacion, verifique los campos',
                'error' => $validatedData->errors()
            ],422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => 0, 'message' => 'Secretari@ no encontrado'], 404);
        }

        // Actualizar los datos del secretario
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];

        $user->save(); // Guardar cambios

        return response()->json([
            'success' => 1,
            'message' => 'Datos del secretari@ actualizados correctamente',
        ], 200);
    }

    public function VerServiciosBarbero($id){
        $barber = User::find($id);

        if (!$barber) {
            return response()->json(['success' => 0, 'message' => 'Barbero no encontrado'], 404);
        }

        $cantidadServicios = $barber->services()->count();

        return response()->json([
            'success' => 1,
            'cantidad_servicios' => $cantidadServicios,
            'message' => 'Cantidad de servicios del barbero obtenida correctamente',
        ], 200);
    } */
}

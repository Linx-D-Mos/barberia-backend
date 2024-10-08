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

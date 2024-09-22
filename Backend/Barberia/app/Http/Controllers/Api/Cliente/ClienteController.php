<?php

namespace App\Http\Controllers\Api\Cliente;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ClienteController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

     public function show(User $user)
     {
         return response()->json($user);
     }

      /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\Models\User  $user
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, User $user)
     {
         $validatedData = $request->validate([
             'name' => 'sometimes|required|string|max:250',
             'celular' => 'sometimes|integer|digits:10',
             'password' => 'sometimes|required|string|min:8|confirmed',
         ]);

          // Actualiza  usuario
          $user->update(array_filter($validatedData, fn($value) => !is_null($value)));
          // Devuelve una respuesta
          return response()->json($user);
     }

    /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Models\User  $user
      * @return \Illuminate\Http\Response
      */

     public function destroy(User $user)
     {
         $user->delete();

         return response()->json(null, 204);
     }

    // Un cliente al registrarse debe elegir a que peluquería se va a afiliar
    /**
     * @OA\Put(
     *     path="/api/cliente/barbershop_affiliate",
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
     *    @OA\Response(response=401, description="El usuario no está verificado"),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
     public function barbershopAffiliate(Request $request){
        // Validar que el usuario esté validado
        if (!$request->user()->hasVerifiedEmail()) {
            return response()->json([
                'success' => 0,
                'message' => 'El usuario no está verificado',
            ], 401);
        }
        
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
}

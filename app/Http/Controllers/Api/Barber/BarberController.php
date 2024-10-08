<?php

namespace App\Http\Controllers\Api\Barber;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;

class BarberController
{
    // quiero ver todas las citas pendientes que tengo
    /**
     * @OA\Get(
     *     path="api/barber/pending_quotes",
     *     tags={"Citas Pendientes"},
     *     summary="Obtiene las citas pendientes del barbero",
     *     description="Devuelve una lista de citas reservadas con el barbero.",
     *     operationId="citasPendientes",
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Citas encontradas",
     *         @OA\JsonContent(type="array",
     *               @OA\Schema(
     *                  schema="quotes",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="client_id", type="integer", example=10),
     *                  @OA\Property(property="barber_id", type="integer", example=5),
     *                  @OA\Property(property="assigned", type="string", format="date-time", example="2023-10-08T14:00:00Z"),
     *                  @OA\Property(property="status", type="string", enum={"RESERVADA", "CANCELADA", "TERMINADA", "ACEPTADA"}, example="RESERVADA"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró el perfil del barbero",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No se encontró el perfil del barbero")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No autenticado.")
     *         )
     *     )
     * )
     */
    public function citasPendientes(Request $request)
    {
        $perfil_barbero = Profile::with('quotes')
            ->where('user_id', $request->user()->id)
            ->first();

        if(!$perfil_barbero) {
            return response()->json([
                'message' => 'No se encontró el perfil del barbero'
            ], 404);
        }

        $citas = $perfil_barbero->quotes()->where('status', 'RESERVADA')->get();

        // datos del cliente relacionado con la cita
        $citas->client();

        // servicios de la cita
        $citas->services();

        return response()->json($citas);
    }

    /**
     * @OA\Get(
     *     path="/api/barber/profile",
     *     tags={"Barbero"},
     *     summary="Obtener el perfil del barbero",
     *     description="Devuelve el perfil del usuario asociado al rol de barbero.",
     *     operationId="PerfilBarber",
     *     @OA\Response(
     *         response=200,
     *         description="Perfil del barbero encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Perfil del barbero"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="barbershop_id", type="integer", example=3),
     *                 @OA\Property(property="role_id", type="integer", example=4),
     *                 @OA\@OA\Property(property= "status", type="string", example='ACTIVO'),
     *
     *                 @OA\@OA\Property(property= "name", type="string", example='Arnulfo Carepalo'),
     *                 @OA\@OA\Property(property= "email", type="string", example='ArnPalo@barberconect.co'),
     *                 @OA\@OA\Property(property= "phone", type="string", example='301121343'),
     *                 @OA\@OA\Property(property= "photo", type="string"),
     *                 @OA\@OA\Property(property= "nickname", type="string", example='madera'),
     *                 @OA\@OA\Property(property= "birth", type="date", example='1995-03-22'),
     *                 @OA\@OA\Property(property= "password", type="string", example='*********'),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Perfil del barbero no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="integer", example=0),
     *             @OA\Property(property="message", type="string", example="No se encontró el perfil del usuario")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function PerfilBarber(Request $request){


        $profile = Profile::with(['user', 'barbershop', 'role'])->where(
            'user_id', $request->user()->id)->first();

        if (!$profile) {
            return response()->json([
                'success' => 0,
                'message' => 'No se encontró el perfil del barbero'
            ], 404);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Perfil del barbero',
            'data' => $profile
        ]);
    }

     //brrrrrrrrrr
    //metodo para agendar cita
  /*  public function AgendarCita (Request $request){
        //validacion de datos
        $validate = Validator::make($request->all(),
        [
            'cliente_id' => 'required|exists:users,id',
            'servicios' => 'required|array',
            'servicios.*' => 'exists:services,id',
            'fecha_hora' => 'required|date|after:now',
        ]);

        if($validate->fails()){
            return response()->json(
                [
                    'errors'=> $validate->errors()
                ], 422
            );
        }

        $barber = Profile::where('user_id', $request->user()->id)->first();
        if(!$barber){
            return response()->json([
                'message' => 'El perfil del barbero no se encontro'
            ], 404);
        }

        //crear la ciyta
        $cita = new Quote();
        $cita ->client_id = $request->client_id;
        $cita->barber_id = $barber->id;
        $cita->date_time = $request->fecha_hora;
        $cita->status = 'RESERVADA';
        $cita->save();

        //agregar servicios a la cita
        foreach($request->servicios as $servicioId)
        {
            QuoteService::create([
                'quote_id' => $cita->id,
                'service_id' => $servicioId,
            ]);
        }
        return response()->json([
            'message' => 'Cita agendada con éxito',
            'cita' => $cita->load(['client', 'services']), //carga relaciones para la respuesta
        ], 201);
    }

    public function Add_serviciosAcita(Request $request, $cita_id){
        $validator = Validator::make($request->all(),
        [
            'servicios' => 'required|array',
            'servicios.*' => 'exists:services,id',
        ]);

        if ($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }
        //verificar que la cita existe
        $sita = Quote::find($cita_id);
        if(!$sita){
            return response()->json([
                'message' => 'Cita no encontrada'
            ],404);
        }
        //verificar que sea el mismo barbero para poder agregar el servicio
        $barbero = Profile::where('user_id', $request->user()->id)->first();
        if($sita->baber_id !== $barbero->id){
            return response()->json([
                'message' => 'No tienes permiso para modificar esta cita'
            ], 403);
        }

        //agregar el servio a la cita
        foreach ($request->servicios as $serviceId) {
            QuoteService::create([
                'quote_id' => $sita->id,
                'service_id' => $serviceId,
            ]);
        }
        return response()->json(
            [
                'message' => 'Servicios añadidos a la cita',
                'cita' => $sita->load(['client', 'services']),
            ], 200
        );
    } */
}

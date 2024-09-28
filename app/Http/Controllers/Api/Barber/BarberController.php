<?php

namespace App\Http\Controllers\Api\Barber;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;

class BarberController
{
    // quiero ver todas las citas pendientes que tengo
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

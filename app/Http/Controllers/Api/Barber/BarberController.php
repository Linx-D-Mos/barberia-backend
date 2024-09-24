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

}

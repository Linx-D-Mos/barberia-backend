<?php

namespace App\Http\Controllers\Api;

use App\Models\Barbershop;
use Illuminate\Http\Request;

class BarberShopController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barber = Barbershop::all();
        return response()->json($barber);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //funciones para ver los registros
    public function ShowBarberos(Barbershop $barbershop){
        //obtener los perfiles de los barberos que pertenecen a la barberia
        $barberos = Profile::where('barbershop_id', $barbershop->id)->with('user')->get();
        return response()->json($barberos);
    }

    public function showClientes(BarberShop $barberias)
    {
        $clientes = Profile::where('barbershop_id', $barberias->id)->where('role_id', '') ->with('user')->get();
        // el '' es para darle el numero al cual este asignado el rol de cliente
        return response()->json($clientes);
    }
}

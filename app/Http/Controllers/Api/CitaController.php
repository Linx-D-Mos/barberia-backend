<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Cita;
use COM;

class CitaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cita::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:100',
            'fecha_hora' => 'required|date',
            'servicio' => 'required|string|max:100',
        ]);

        $cita = Cita::create($request->all());
        return response()->json($cita, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Cita::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:100',
            'fecha_hora' => 'required|date',
            'servicio' => 'required|string|max:100',
        ]);

        $cita = Cita::findOrFail($id);
        $cita->update($request->all());
        return response()->json($cita);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();
        return response()->json(['message'=> 'cita eliminafa'], 204);
    }
}

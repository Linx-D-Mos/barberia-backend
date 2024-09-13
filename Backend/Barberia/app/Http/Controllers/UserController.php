<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    /**
     * perfil del usuario
     */
    public function profile(string $id)
    {
        // obtener el perfil del usuario
        $user = User::with('profile')->find($id);
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Perfil del usuario',
                'datum' => $user->profile
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ]);
        }
    }
}

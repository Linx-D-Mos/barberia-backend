<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    /** public function profile(string $id)
    *{
     *   // obtener el perfil del usuario
      *  $user = User::with('profile')->find($id);
       * if ($user) {
        *    return response()->json([
         *       'success' => true,
          *      'message' => 'Perfil del usuario',
          *      'datum' => $user->profile
          *  ]);
        *}else{
         *   return response()->json([
          *      'success' => false,
           *     'message' => 'Usuario no encontrado',
            *]);
       * }
    *} */
}

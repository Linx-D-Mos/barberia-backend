<?php

namespace App\Http\Controllers\Api\Barbero;

use Illuminate\Http\Request;
use App\Models\User;

class BarberoController
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'celular' => 'required|integer|digits:10',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'celular' => $validatedData['celular'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json($user, 201);
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

}

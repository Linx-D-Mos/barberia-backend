<?php

namespace App\Http\Controllers\Api\Dueno;

use App\Models\Profile;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class DuenoController
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
      */
     public function update(Request $request)
     {
         //
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


     public function registrarBarbero(Request $request) {

        // Validaciones
        $validatedData = Validator::make( $request->all(), [
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
            'role_id' => Role::where('name', 'barber')->first()->id,
        ]);

        // Respuesta
        return response()->json([
            'success' => 1,
            'message' => 'Barbero registrado correctamente',
        ], 200);
     }


     public function registrarSecretary(Request $request) {

        // Validaciones
        $validatedData = Validator::make( $request->all(), [
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
}

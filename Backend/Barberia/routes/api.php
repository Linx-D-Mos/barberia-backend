<?php

use App\Http\Controllers\Api\CitaController;
use App\Http\Controllers\Api\Cliente\ClienteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Register\RegisterController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// perfil del usuario
//Route::get('/users/{id}/profile', [UserController::class, 'profile']);
// Route::apiResource('barberos', BarberoController::class);
// Route::apiResource('clientes', ClienteController::class);
// Route::apiResource('duenos', DuenoController::class);
// Route::apiResource('users', UserController::class);
Route::apiResource('citas', CitaController::class);


Route::prefix('/auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);

    // rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::get('/logout', [UserController::class, 'logout']);
        // Route::post('/refresh', [LoginController::class, 'refresh']);
    });
});

// Rutas para el perfil del cliente
Route::prefix('/cliente')->group(function () {
    // Rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/barbershop_affiliate', [ClienteController::class, 'barbershopAffiliate']);
    });
});
<?php

use App\Http\Controllers\Api\BarberoController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\DuenoController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// perfil del usuario
//Route::get('/users/{id}/profile', [UserController::class, 'profile']);
Route::apiResource('barberos', BarberoController::class);
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('duenos', DuenoController::class);
Route::apiResource('users', UserController::class);


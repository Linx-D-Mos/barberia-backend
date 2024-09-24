<?php

use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Owner\OwnerController;
use App\Http\Controllers\Api\Root\RootController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Logout\LogoutController;
use App\Http\Controllers\Auth\Register\RegisterController;
use App\Http\Controllers\Auth\ResetPassword\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmail\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::prefix('/auth')->group(function () {

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    // enviar código de verificación
    Route::post('/send_reset_password_code', [ResetPasswordController::class, 'sendResetPasswordCode']);
    // verificar código de verificación
    Route::post('/verify_reset_password_code', [ResetPasswordController::class, 'verifyResetPasswordCode']);
    
    // rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        // verificar correo electrónico
        Route::post('/verify_email', [VerifyEmailController::class, 'verifyEmail'])
            ->middleware('ability:client');

        Route::middleware('verified')->group(function () {
            Route::get('/profile', [UserController::class, 'profile']);
            Route::get('/logout', [LogoutController::class, 'logout']);
        });
    });

});

// Rutas para el perfil del cliente
Route::prefix('/client')->middleware(['auth:sanctum', 'ability:client', 'verified'])->group(function () {
    // afiliarse a una barbería
    Route::put('/barbershop_affiliate', [ClientController::class, 'barbershopAffiliate']);
});

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');

// Rutas para el root
Route::prefix('/root')->middleware(['auth:sanctum', 'ability:root', 'verified'])->group(function () {
    // crear un usuario owner
    Route::post('/create_owner', [RootController::class, 'createOwner']);
});

// Rutas para el propietario
Route::prefix('/owner')->middleware(['auth:sanctum', 'ability:owner', 'verified'])->group(function () {
    // crear un barbero
    Route::post('/create_barber', [OwnerController::class, 'createBarber']);
});
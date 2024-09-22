<?php

use App\Http\Controllers\Api\CitaController;
use App\Http\Controllers\Api\Cliente\ClienteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Logout\LogoutController;
use App\Http\Controllers\Auth\Register\RegisterController;
use App\Http\Controllers\Auth\ResetPassword\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmail\VerifyEmailController;
use Illuminate\Support\Facades\Route;


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
    // enviar código de verificación
    Route::post('/send_reset_password_code', [ResetPasswordController::class, 'sendResetPasswordCode']);
    // verificar código de verificación
    Route::post('/verify_reset_password_code', [ResetPasswordController::class, 'verifyResetPasswordCode']);
    
    // rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        // verificar correo electrónico
        Route::post('/verify_email', [VerifyEmailController::class, 'verifyEmail']);
        Route::get('/profile', [UserController::class, 'profile']);
        Route::get('/logout', [LogoutController::class, 'logout']);
    });

});

// Rutas para el perfil del cliente
Route::prefix('/cliente')->group(function () {
    // Rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        // afiliarse a una barbería
        Route::put('/barbershop_affiliate', [ClienteController::class, 'barbershopAffiliate']);
    });
});
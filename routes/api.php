<?php

use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\Barber\BarberController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BarberShopController;

use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Owner\OwnerController;
use App\Http\Controllers\Api\QuoteServiceController;
use App\Http\Controllers\Api\Root\RootController;
use App\Http\Controllers\Api\ServiceController as ApiServiceController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Logout\LogoutController;
use App\Http\Controllers\Auth\Register\RegisterController;
use App\Http\Controllers\Auth\ResetPassword\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmail\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Architecture\Services\ServiceContainer;

Route::prefix('/auth')->group(function () {

    Route::post('/login', [LoginController::class, 'login']);// 404 not found
    Route::post('/register', [RegisterController::class, 'register']); //404 not found
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
Route::prefix('/client')->middleware(['auth:sanctum', 'ability:client', 'verified'])->group(function () {//404 not found
    // afiliarse a una barbería
    Route::put('/barbershop_affiliate', [ClientController::class, 'barbershopAffiliate']);
    // ver perfil
    Route::get('/profile', [ClientController::class, 'perfil']);
});

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');// 500 internal error server

// Rutas para el root
Route::prefix('/root')->middleware(['auth:sanctum', 'ability:root', 'verified'])->group(function () {
    // crear un usuario owner
    Route::post('/create_owner', [RootController::class, 'createOwner']);
});

// Rutas para el propietario
Route::prefix('/owner')->middleware(['auth:sanctum', 'ability:owner', 'verified'])->group(function () {
    // crear un barbero
    Route::post('/create_barber', [OwnerController::class, 'createBarber']);//404 not found
});

// Rutas para el barbero
Route::prefix('/barber')->middleware(['auth:sanctum', 'ability:barber', 'verified'])->group(function () {
    // ver perfil del barbero
    Route::get('/profile', [BarberController::class, 'perfil']);
    // ver citas pendientes
    Route::get('/pending_quotes', [BarberController::class, 'citasPendientes']);
});

Route::prefix('/photo')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/upload', [PhotoController::class, 'uploadPhoto']);
});

//brrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

Route::get('/services', [ApiServiceController::class, 'index']);//ya esta --> ruta de servicios para verlos
Route::get('/services/search/name/{name}', [ApiServiceController::class, 'BuscarByName']);//ya esta
Route::get('/services/search/price/{price}', [ApiServiceController::class, 'BuscarByPrice']);//ya esta

Route::get('/owner/barbershops', [BarbershopController::class, 'index']);//ya esta -->ruta de barberos para verlos
Route::get('/owner/barbershops/{barberia}/barbers', [BarberShopController::class, 'ShowBarberos']);
Route::get('/owner/barbershops/{barberShop}/clients', [BarberShopController::class, 'showClientes']);//para ver los clientes

Route::get('/users', [UserController::class, 'index']);//ya esta
Route::get('/profiles', [ProfileController::class, 'index']);//ya esta


Route::get('/quotes', [QuoteController::class, 'index']);// esta ok pero no muestra nada
Route::get('/quotes/services', [QuoteServiceController::class, 'index']);//ok pero no muestra nada

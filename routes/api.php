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
use App\Http\Controllers\Api\ScheduleController;
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

// TODO: Rutas para el ROOT
Route::prefix('/root')->middleware(['auth:sanctum', 'ability:root', 'verified'])->group(function () {
    // crear un usuario owner
    Route::post('/create_owner', [RootController::class, 'createOwner']);
    // ver todos los dueños
    Route::get('/owners', [RootController::class, 'showOwners']);
    // recursos de usuarios
    Route::apiResource('users', UserController::class);

    Route::prefix('/barbershops/{barbershop}')->group(function () {
        // bloquear una barbería
        Route::put('/block', [RootController::class, 'blockBarbershop']);
        // desbloquear una barbería
        Route::put('/unblock', [RootController::class, 'unblockBarbershop']);
    });
});

// TODO: Rutas para el PROPIETARIO
Route::prefix('/owner')->middleware(['auth:sanctum', 'ability:owner', 'verified'])->group(function () {
    // ver mis barberías
    Route::get('/barbershops', [OwnerController::class, 'myBarbershops']);

    Route::prefix('/barbershops/{barbershop}')->middleware(['check.barbershop.status'])->group(function () {
        // crear un barbero
        Route::post('/create_barber', [OwnerController::class, 'createBarber']);
    });
});

// TODO: Rutas para el BARBERO
Route::prefix('/barber')->middleware(['auth:sanctum', 'ability:barber', 'verified', 'active', 'babershop.status'])->group(function () {
    // ver perfil del barbero
    // Route::get('/profile', [BarberController::class, 'perfil']);
    // ver citas pendientes
    Route::get('/pending_quotes', [BarberController::class, 'citasPendientes']);
});

// TODO: Rutas para el perfil del CLIENTE
Route::prefix('/client')->middleware(['auth:sanctum', 'ability:client', 'verified', 'active'])->group(function () {
    // ver perfil
    Route::get('/profile', [ClientController::class, 'perfil']);
    // afiliarse a una barbería
    Route::put('/barbershop_affiliate', [ClientController::class, 'barbershopAffiliate']);

    // protección para las rutas que requieren que el usuario esté afiliado a una barbería
    Route::middleware('babershop.status')->group(function () {
        // ver los horarios de la barbería
        Route::post('/schedule_barbershop', [ScheduleController::class, 'scheduleBarbershop']);
    });
});


Route::prefix('/photo')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/upload', [PhotoController::class, 'uploadPhoto']);
});

//brrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

Route::get('/services', [ApiServiceController::class, 'index']);//ya esta --> ruta de servicios para verlos
Route::get('/services/search/name/{name}', [ApiServiceController::class, 'BuscarByName']);//ya esta
Route::get('/services/search/price/{price}', [ApiServiceController::class, 'BuscarByPrice']);//ya esta

// esta ruta está mala @TyroneJos3
// Route::get('/owner/barbershops', [BarbershopController::class, 'index']);//ya esta -->ruta de barberos para verlos
Route::get('/owner/barbershops/{barberia}/barbers', [BarberShopController::class, 'ShowBarberos']);
Route::get('/owner/barbershops/{barberShop}/clients', [BarberShopController::class, 'showClientes']);//para ver los clientes

Route::get('/users', [UserController::class, 'index']);//ya esta
Route::get('/profiles', [ProfileController::class, 'index']);//ya esta


Route::get('/quotes', [QuoteController::class, 'index']);// esta ok pero no muestra nada
Route::get('/quotes/services', [QuoteServiceController::class, 'index']);//ok pero no muestra nada

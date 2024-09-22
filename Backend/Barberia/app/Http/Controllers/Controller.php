<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *    title="Barberia API",
 *    version="1.0.0",
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="ApiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Ingresar el token de autorización",
 *     scheme="bearer",
 *     bearerFormat="Bearer {token}",
 * )
 */
abstract class Controller
{
    //
}

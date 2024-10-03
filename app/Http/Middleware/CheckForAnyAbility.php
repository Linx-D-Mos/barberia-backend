<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Illuminate\Http\JsonResponse;

class CheckForAnyAbility
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$abilities
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\AuthenticationException|\Laravel\Sanctum\Exceptions\MissingAbilityException
     */
    public function handle($request, $next, ...$abilities)
    {
        if (! $request->user() || ! $request->user()->currentAccessToken()) {
            return response()->json([
                'success' => 0,
                'message' => 'No estás autenticado. Necesitas inicar sesión.'
            ], 401);
        }

        foreach ($abilities as $ability) {
            if ($request->user()->tokenCan($ability)) {
                return $next($request);
            }
        }

        $habilidades = implode(', ', $abilities);

        return response()->json([
            'success' => 0,
            'message' => 'No tienes permisos para realizar esta acción. Necesitas permisos de: ' . $habilidades,
        ], 403);
    }
}
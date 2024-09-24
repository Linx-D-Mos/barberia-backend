<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! $request->user()->hasVerifiedEmail()) {
            return response()->json([
                'success' => 0,
                'message' => 'Debe verificar su correo electrónico para continuar.'
            ], 401);
        }

        return $next($request);
    }
}

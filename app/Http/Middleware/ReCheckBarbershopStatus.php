<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReCheckBarbershopStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $barbershop = $user->profile->barbershop;

        if ($barbershop && $barbershop->status === 'BLOQUEADA') {
            return response()->json([
                'success' => 0,
                'message' => 'No puedes realizar acciones. La barbería está bloqueada.'
            ], 403);
        }
        return $next($request);
    }
}

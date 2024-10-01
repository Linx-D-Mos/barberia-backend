<?php

namespace App\Http\Middleware;

use App\Models\Barbershop;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBarbershopStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $barbershopId = $request->route('barbershop');

        if (!$barbershopId) {
            return response()->json([
                'success' => 0,
                'message' => 'ID de barbería no proporcionado.'
            ], 400);
        }

        $barbershop = Barbershop::find($barbershopId);

        if (!$barbershop) {
            return response()->json([
                'success' => 0,
                'message' => 'Barbería no encontrada.'
            ], 404);
        }

        if ($barbershop->owner_id !== $user->id) {
            return response()->json([
                'success' => 0,
                'message' => 'No tienes permiso para realizar acciones en esta barbería.'
            ], 403);
        }

        if ($barbershop->status === 'BLOQUEADA') {
            return response()->json([
                'success' => 0,
                'message' => 'No puedes realizar acciones. La barbería está bloqueada.'
            ], 403);
        }
        
        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Jobs\CreateBarberTimeSlots;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageBarbersController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/owner/barbershops/{barbershop}/create_barber",
     *     operationId="CreateBarber",
     *     tags={"Dueño"},
     *     summary="Crear barbero",
     *     description="Crea un nuevo barbero en la aplicación",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="barbershop",
     *         in="path",
     *         required=true,
     *         description="ID de la barbería",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "phone"},
     *               @OA\Property(property="name", type="string", example="John Doe"),
     *               @OA\Property(property="email", type="string", example="john@example.com"),
     *               @OA\Property(property="phone", type="string", example="1234567890"),
     *               @OA\Property(property="nickname", type="string", example="Johnny"),
     *               @OA\Property(property="birth", type="string", format="date", example="1990-01-01"),
     *            ),
     *        ),
     *    ),
     *    @OA\Response(response=200, description="Barbero registrado correctamente"),
     *    @OA\Response(response=400, description="Solicitud incorrecta"),
     *    @OA\Response(response=401, description="No autorizado"),
     *    @OA\Response(response=403, description="Prohibido"),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     *    @OA\Response(response=422, description="Error de validación"),
     * )
     */
    public function createBarber(Request $request, int $barbershop_id)
    {

        // Validaciones
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'nickname' => 'nullable|string|max:50',
            'birth' => 'nullable|date',
        ]);

        // si falla la validación
        if ($validatedData->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        try {
            DB::transaction(function () use ($request, $barbershop_id) {
                $user = User::create($request->all() + [
                    'photo' => 'https://barber-connect-images.s3.us-east-2.amazonaws.com/default/default.jpg',
                    // lo siguiente no debería ir aquí, pero por fines de prueba lo dejé
                    'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'password' => bcrypt($request->phone),
                ]);
        
                $profile = Profile::create([
                    'user_id' => $user->id,
                    'role_id' => Role::where('name', 'barber')->first()->id,
                    'barbershop_id' => $barbershop_id,
                ]);
        
                // Despachar el Job
                CreateBarberTimeSlots::dispatch($profile->id, $barbershop_id);
            });
        
            return response()->json([
                'success' => 1,
                'message' => 'Barbero registrado correctamente. Los horarios se están generando en segundo plano.',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => 0,
                'message' => 'Error al registrar el barbero',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // private function createWeeklyTimeSlots($barber_id, $barbershop_id)
    // {
    //     $barbershopSchedules = Schedule::where('barbershop_id', $barbershop_id)->get();

    //     foreach ($barbershopSchedules as $schedule) {
    //         if (!$schedule->is_available) {
    //             continue; // Saltar horarios no disponibles
    //         }

    //         $startTime = Carbon::parse($schedule->start_time);
    //         $endTime = Carbon::parse($schedule->end_time);

    //         $currentTime = $startTime->copy();

    //         while ($currentTime < $endTime) {
    //             $slotEnd = $currentTime->copy()->addMinutes(15);

    //             // Asegúrate de que el último slot no exceda el horario de cierre
    //             if ($slotEnd > $endTime) {
    //                 $slotEnd = $endTime;
    //             }

    //             TimeSlot::create([
    //                 'barber_id' => $barber_id,
    //                 'day' => $schedule->day,
    //                 'start_time' => $currentTime->format('H:i'),
    //                 'end_time' => $slotEnd->format('H:i'),
    //                 'is_taken' => false,
    //             ]);

    //             $currentTime->addMinutes(15);
    //         }
    //     }
    // }
}

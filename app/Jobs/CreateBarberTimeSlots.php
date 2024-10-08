<?php

namespace App\Jobs;

use App\Models\Schedule;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateBarberTimeSlots implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $barber_id;
    protected $barbershop_id;

    public function __construct($barber_id, $barbershop_id)
    {
        $this->barber_id = $barber_id;
        $this->barbershop_id = $barbershop_id;
    }

    public function handle()
    {
        Log::info('Iniciando CreateBarberTimeSlots para barber_id: ' . $this->barber_id);

        $barbershopSchedules = Schedule::where('barbershop_id', $this->barbershop_id)->get();

        Log::info('Encontrados ' . $barbershopSchedules->count() . ' horarios para la barbería ID: ' . $this->barbershop_id);

        foreach ($barbershopSchedules as $schedule) {
            if (!$schedule->is_available) {
                Log::info('Horario no disponible para el día: ' . $schedule->day);
                continue;
            }

            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);

            $currentTime = $startTime->copy();
            $slotsCreated = 0;

            while ($currentTime < $endTime) {
                $slotEnd = $currentTime->copy()->addMinutes(15);

                if ($slotEnd > $endTime) {
                    $slotEnd = $endTime;
                }

                TimeSlot::create([
                    'barber_id' => $this->barber_id,
                    'day' => $schedule->day,
                    'start_time' => $currentTime->format('H:i'),
                    'end_time' => $slotEnd->format('H:i'),
                    'is_taken' => false,
                ]);

                $slotsCreated++;
                $currentTime->addMinutes(15);
            }

            Log::info("Creados $slotsCreated slots para el día {$schedule->day} (Barbero ID: {$this->barber_id})");
        }

        Log::info('Finalizado CreateBarberTimeSlots para barber_id: ' . $this->barber_id);
    }
}

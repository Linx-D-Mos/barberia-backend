<?php

namespace Database\Seeders;

use App\Models\Barbershop;
use App\Models\Schedule;
use Database\Factories\ScheduleFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $barbershops = Barbershop::all();
        $daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        foreach ($barbershops as $barbershop) {
            foreach ($daysOfWeek as $day) {
                Schedule::factory()->create([
                    'barbershop_id' => $barbershop->id,
                    'day' => $day,
                ]);
            }
        }
    }
}

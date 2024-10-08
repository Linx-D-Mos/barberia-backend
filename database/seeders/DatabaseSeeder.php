<?php

namespace Database\Seeders;

use App\Models\Barbershop;
use App\Models\Note;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Models\Quote;
use App\Models\QuoteService;
use App\Models\Schedule;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ferney Caicedo',
            'email' => 'root.ferney@gmail.com',
            'phone' => '3123456789',
            'password' => bcrypt('********'),
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Todo: Crear roles. IMPORTANTE**: No modificar.
        Role::factory()->createMany([
            ['name' => 'root',],
            ['name' => 'owner',],
            ['name' => 'admin',],
            ['name' => 'secretary',],
            ['name' => 'barber',],
            ['name' => 'client',],
        ]);

        Profile::create([
            'user_id' => 1,
            'role_id' => 1,
            'barbershop_id' => null,
        ]);

        User::factory(30)->create();
        Barbershop::factory(30)->create();
        Profile::factory(30)->create();
        Service::factory(30)->create();
        // Quote::factory(10)->create(); // Esto está malo @TyroneJos3
        // QuoteService::factory(10)->create();
        // Note::factory(10)->create(); // Corregir @TyroneJos3

         /* User::factory()->create([
            'name' => 'Austin Porro',
            'email' => 'wacho.porto@gmail.com',
            'phone' => '3126547890',
            'password' => bcrypt('987654'),
        */

        $this->call([
            ScheduleSeeder::class,
        ]);
    }
}

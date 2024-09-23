<?php

namespace Database\Seeders;

use App\Models\Barbershop;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
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

        User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        // Todo: Crear roles. IMPORTANTE**: No modificar.
        Role::factory()->createMany([
            ['name' => 'root',],
            ['name' => 'owner',],
            ['name' => 'admin',],
            ['name' => 'secretary',],
            ['name' => 'barber',],
            ['name' => 'client',],
        ]);

        Barbershop::factory(10)->create();

        Profile::factory()->create([
            'user_id' => 1,
            'role_id' => 1,
            'barbershop_id' => null,
        ]);

        Profile::factory(5)->create();

    }
}

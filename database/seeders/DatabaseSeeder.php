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
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* User::factory()->create([
            'name' => 'Ferney Caicedo',
            'email' => 'root.ferney@gmail.com',
            'phone' => '3123456789',
            'password' => bcrypt('********'),
        ]);

        User::factory(10)->create();

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

        Barbershop::factory(10)->create();

        Profile::factory()->create([
            'user_id' => 1,
            'role_id' => 1,
            'barbershop_id' => null,
        ]);

        Profile::factory(5)->create(); */

        /* Service::factory()->createMany([
            [
                'name' => 'Corte de cabello clásico',
                'description' => 'Corte tradicional con tijeras y máquina',
                'price' => 25000.00,
                'barbershop_id' => 1,
            ],
            [
                'name' => 'Afeitado con navaja',
                'description' => 'Afeitado profesional con navaja y toalla caliente',
                'price' => 20000.00,
                'barbershop_id' => 1,
            ],
            [
                'name' => 'Corte y barba',
                'description' => 'Combinación de corte de cabello y arreglo de barba',
                'price' => 40000.00,
                'barbershop_id' => 1,
            ],
            [
                'name' => 'Fade',
                'description' => 'Corte degradado con diseño personalizado',
                'price' => 30000.00,
                'barbershop_id' => 1,
            ],
            [
                'name' => 'Tratamiento capilar',
                'description' => 'Tratamiento hidratante para cabello dañado',
                'price' => 35000.00,
                'barbershop_id' => 2,
            ],
            [
                'name' => 'Tinte de cabello',
                'description' => 'Coloración completa con productos de calidad',
                'price' => 70000.00,
                'barbershop_id' => 2,
            ],
            [
                'name' => 'Corte infantil',
                'description' => 'Corte especial para niños menores de 12 años',
                'price' => 18000.00,
                'barbershop_id' => 3,
            ],
            [
                'name' => 'Peinado para eventos',
                'description' => 'Peinado y estilizado para ocasiones especiales',
                'price' => 45000.00,
                'barbershop_id' => 4,
            ],
            [
                'name' => 'Depilación de cejas',
                'description' => 'Diseño y depilación de cejas con hilo',
                'price' => 15000.00,
                'barbershop_id' => 4,
            ],
            [
                'name' => 'Masaje capilar',
                'description' => 'Masaje relajante de cuero cabelludo con aceites esenciales',
                'price' => 25000.00,
                'barbershop_id' => 4,
            ],
        ]); */

         Barbershop::factory(15)->create();
         User::factory(20)->create();
         Profile::factory(10)->create();
         Service::factory(30)->create();
         QuoteService::factory(30)->create();
         Quote::factory(20)->create();
         Note::factory(30)->create();

         /* User::factory()->create([
            'name' => 'Austin Porro',
            'email' => 'wacho.porto@gmail.com',
            'phone' => '3126547890',
            'password' => bcrypt('987654'),
*/


    }
}

<?php

namespace Database\Factories;

use App\Models\Barbershop;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::where('name', '!=', ['owner', ])->get()->random();

        $usersWithoutProfile = User::doesntHave('profile')->pluck('id')->toArray();
        
        $user_id = fake()->unique()->randomElement($usersWithoutProfile);
        
        $barbershop = Barbershop::where('owner_id', $user_id)->first();
        if ($barbershop) {
            $role = Role::where('name', 'owner')->first();
        }
        
        return [
            'user_id' => $user_id,
            'role_id' => $role->id,
            'barbershop_id' => $role->id === Role::where('name', 'owner')->first()->id ? null : Barbershop::all()->random()->id,
        ];
    }
}

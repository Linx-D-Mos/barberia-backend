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
        static $userIds;

        if (!$userIds) {
            // Obtener todos los user_id que no tienen perfil en 'profiles'
            $userIds = User::whereNotIn('id', Profile::pluck('user_id'))->pluck('id')->toArray();
        }

        // Obtener el próximo user_id disponible
        $userId = array_shift($userIds);
        
        return [
            'user_id' => $userId,
            'role_id' => Role::all()->random()->id,
            'barbershop_id' => Barbershop::all()->random()->id,
            'status' => 'ACTIVO',
        ];
    }
}

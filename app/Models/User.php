<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Properties\CustomDateTime;
use App\Traits\Properties\CustomSetAttribute;
use App\Traits\Security\ResetPassword;
use App\Traits\Security\UserStatus;
use App\Traits\Security\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory, Notifiable;
    use VerifyEmail, ResetPassword;
    use CustomDateTime, CustomSetAttribute;
    use UserStatus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'nickname',
        'birth',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    /**
     * Obtener el perfil asociado con el usuario
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Obtener las barberias que me pertenecen como dueño
     */
    public function barbershops()
    {
        return $this->hasMany(Barbershop::class, 'owner_id');
    }
}

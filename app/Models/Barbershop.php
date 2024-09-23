<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbershop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'number',
        'tokenwaapi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'tokenwaapi',
    ];

    /**
     * Obtener los perfiles de la barbería
     */
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Obtener los servicios de la barbería
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use App\Traits\Properties\CustomSetAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbershop extends Model
{
    use HasFactory;
    use CustomDateTime;

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

    /**
     * Obtener el propietario de la barbería
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener los horarios de la barbería
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}

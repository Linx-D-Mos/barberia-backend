<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'role_id',
        'barbershop_id',
        'status',
    ];
    
    
    /**
     * Obtener el usuario propietario del perfil
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el rol del perfil
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Obtener la barbería del perfil
     */
    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class);
    }

    /**
     * Obtener las citas del perfil
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Obtener las notas del perfil
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Obtener las calificaciones del perfil
     */
    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    /**
     * Obtener las atenciones del perfil
     */
    public function attentions()
    {
        return $this->hasMany(Attention::class);
    }

    
}
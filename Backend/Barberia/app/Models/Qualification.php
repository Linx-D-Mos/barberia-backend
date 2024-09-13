<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'barber_id',
        'score',
        'comment',
    ];

    /**
     * Obtener el cliente de la calificación
     */
    public function client()
    {
        return $this->belongsTo(Profile::class, 'client_id');
    }

    /**
     * Obtener el barbero de la calificación
     */
    public function barber()
    {
        return $this->belongsTo(Profile::class, 'barber_id');
    }
}

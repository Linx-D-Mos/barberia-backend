<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'barber_id',
        'assigned',
        'slots',
        'status',
    ];

    /**
     * Obtener el cliente de la cita
     */
    public function client()
    {
        return $this->belongsTo(Profile::class, 'client_id');
    }

    /**
     * Obtener el barbero de la cita
     */
    public function barber()
    {
        return $this->belongsTo(Profile::class, 'barber_id');
    }

    /**
     * Obtener los servicios de la cita
     */
    public function services()
    {
        return $this->hasMany(QuoteService::class);
    }

    /**
     * Obtener la atencione de la cita
     */
    public function attention()
    {
        return $this->hasOne(Attention::class);
    }
}

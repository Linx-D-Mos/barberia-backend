<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use App\Traits\Properties\CustomSetAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use CustomDateTime, CustomSetAttribute;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'barbershop_id',
    ];

    /**
     * Obtener la barbería a la que pertenece el servicio
     */
    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class);
    }

    /**
     * Obtener las citas de los servicios
     */
    public function quotes()
    {
        return $this->hasMany(QuoteService::class);
    }

    /**
     * Obtener las atenciones de los servicios
     */
    public function attentions()
    {
        return $this->hasMany(AttentionService::class);
    }
}

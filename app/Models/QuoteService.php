<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteService extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quote_id',
        'service_id',
    ];

    /**
     * Obtener la cita a la que pertenece el servicio
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * Obtener el servicio de la cita
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

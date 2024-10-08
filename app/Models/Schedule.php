<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;
    use CustomDateTime;

    protected $fillable = [
        'barbershop_id',
        'day',
        'start_time',
        'end_time',
        'is_available',
    ];

    /**
     * Obtener la barbería a la que pertenece el horario
     */
    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class);
    }
}

<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    /** @use HasFactory<\Database\Factories\TimeSlotFactory> */
    use HasFactory;
    use CustomDateTime;

    protected $fillable = [
        'barber_id',
        'day',
        'start_time',
        'end_time',
        'is_taken',
    ];

    /**
     * Obtener el barbero al que pertenece el horario
     */
    public function barber()
    {
        return $this->belongsTo(Profile::class, 'barber_id');
    }
}

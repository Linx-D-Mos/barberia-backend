<?php

namespace App\Traits\Properties;

use Carbon\Carbon;

trait CustomDateTime
{
    //
    // Modifica el formato en que de muestra la fecha a la zona horaria de Bogotá/Colombia
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('America/Bogota')->toDateTimeString();
    }

    // Modifica el formato en que de muestra la fecha a la zona horaria de Bogotá/Colombia
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('America/Bogota')->toDateTimeString();
    }

    // Modifica el formato en que de muestra la fecha a la zona horaria de Bogotá/Colombia
    public function getEmailVerifiedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('America/Bogota')->toDateTimeString();
    }
}

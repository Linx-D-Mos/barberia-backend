<?php

namespace App\Traits\Properties;

trait CustomSetAttribute
{
    // modificar el formato de entrada del campo 'name'
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    // modificar el formato de entrada del campo 'last_name'
    /* public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtolower($value);
    } */

    // modificar el formato de entrada del campo 'nickname'
    public function setNicknameAttribute($value)
    {
        $this->attributes['nickname'] = strtolower($value);
    }

    // modificar el formato de entrada del campo 'email'
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}

<?php

namespace App\Traits\Security;

trait UserStatus
{
    /**
     * Determinar si el usuario está activo.
     * 
     * @return bool True si el usuario está activo, de lo contrario false.
     */
    public function isActive()
    {
        return $this->profile->status === 'ACTIVO';
    }
}

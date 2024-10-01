<?php

namespace App\Traits\Security;

trait UserStatus
{
    // verificar que el usuario está activo
    public function isActive()
    {
        return $this->status === 'ACTIVO';
    }
}

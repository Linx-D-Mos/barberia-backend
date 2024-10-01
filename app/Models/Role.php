<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use App\Traits\Properties\CustomSetAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
    ];

    /**
     * Obtener los perfiles con este rol
     */
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}

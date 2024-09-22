<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;
    
    /**
     * Indica que la tabla no debe mantener automáticamente las marcas de tiempo
     * `created_at` y `updated_at`.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define la clave primaria de la tabla como 'email'.
     *
     * @var string $primaryKey El nombre de la columna que actúa como clave primaria.
     */
    protected $primaryKey = 'email';

    /**
     * Define el tipo de clave primaria como una cadena.
     *
     * @var string $keyType El tipo de clave primaria.
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'code',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'code' => 'integer',
        ];
    }

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public $timestamps = false; // no necesitamos los campos created_at y updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'table_name',
        'operation',
        'function',
        'row_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime', // 'datetime:Y-m-d H:i:s'
        ];
    }

    /**
     * Obtener el perfil que realizó la acción
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}

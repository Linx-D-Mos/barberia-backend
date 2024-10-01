<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'date',
        'content',
    ];

    /**
     * Obtener el cliente de la nota
     */
    public function client()
    {
        return $this->belongsTo(Profile::class, 'client_id');
    }
}

<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attention extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quote_id',
        'client_id',
        'barber_id',
        'tag',
    ];

    /**
     * Obtener la cita a la que pertenece la atención
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * Obtener el cliente de la atención
     */
    public function client()
    {
        return $this->belongsTo(Profile::class, 'client_id');
    }

    /**
     * Obtener el barbero de la atención
     */
    public function barber()
    {
        return $this->belongsTo(Profile::class, 'barber_id');
    }

    /**
     * Obtener los servicios de la atención
     */
    public function services()
    {
        return $this->hasMany(AttentionService::class);
    }

    /**
     * Obtener los detalles de la factura de la atención
     */
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    
}

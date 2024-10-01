<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttentionService extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attention_id',
        'service_id',
    ];

    /**
     * Obtener la atención a la que pertenece el servicio
     */
    public function attention()
    {
        return $this->belongsTo(Attention::class);
    }

    /**
     * Obtener el servicio de la atención
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Obtener los detalles de la factura de la atención
     */
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}

<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'attention_service_id',
        'value_paid',
        'descount',
        'descount_value',
    ];

    /**
     * Obtener la factura a la que pertenece el detalle
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Obtener la atención de la factura
     */
    public function attentionService()
    {
        return $this->belongsTo(AttentionService::class);
    }
}

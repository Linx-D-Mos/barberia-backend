<?php

namespace App\Models;

use App\Traits\Properties\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    use CustomDateTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'total',
        'payment_method',
        'status',
    ];

    /**
     * Obtener los detalles de la factura
     */
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}

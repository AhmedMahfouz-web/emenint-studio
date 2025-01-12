<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'quotation_number',
        'quotation_date',
        'subtotal',
        'discount',
        'tax_percentage',
        'tax_amount',
        'total',
        'signature',
        'first_note',
        'second_note',
        'status',
        'currency_id'
    ];

    protected $casts = [
        'quotation_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class)->withDefault([
            'code' => 'EGP',
            'symbol' => 'ج.م'
        ]);
    }
}

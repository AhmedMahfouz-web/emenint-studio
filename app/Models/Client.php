<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Invoice;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'code',
        'company',
        'country'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

     protected static function booted()
    {
        static::creating(function ($client) {
            if (empty($client->code)) {
                $client->code = 'CL-' . strtoupper(Str::random(4));
            }
        });
    }
}

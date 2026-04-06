<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'payment_data'
    ];

    protected $casts = [
        'payment_data' => 'array',
        'amount' => 'decimal:2'
    ];
}

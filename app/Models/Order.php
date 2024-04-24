<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_code',
        'quantity',
        'customer_id',
        'service_id',
        'payment_method',
        'payment_status',
        'status',
        'payment',
        'change',
        'total',
    ];
}

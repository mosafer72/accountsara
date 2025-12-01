<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id','provider','provider_id','provider_track_id','provider_order_id',
        'amount','status','request_payload','callback_payload'
    ];

    protected $casts = [
        'amount'           => 'decimal:2',
        'request_payload'  => 'array',
        'callback_payload' => 'array',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}

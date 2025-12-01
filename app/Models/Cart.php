<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        "unit_price",
        "snapshot",
        "extra_items"
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function items()
    {
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'image',
        'banner',
        'is_active',
        'category_id',
        'user_id',
        'active_at',
        'show_on_site',
        'discount_percent',
        'type',
        'sell_count'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function answer()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

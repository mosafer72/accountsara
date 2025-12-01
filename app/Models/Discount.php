<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'value', 'category_id', 'user_id', 'start_at', 'end_at', 'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isActive()
    {
        $now = now();
        return $this->status &&
               (!$this->start_at || $this->start_at <= $now) &&
               (!$this->end_at || $this->end_at >= $now);
    }
    public function isValidFor($price){
            return true;
    }

    public function discountValueFor($price){
        if($this->type=="percentage")
            return ($this->value*$price)/100;
        else
            return $price-$this->value;
    }
}

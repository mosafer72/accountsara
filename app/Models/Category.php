<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    // فیلدهایی که قابل پر شدن هستند
    protected $fillable = [
        'name',
        'description',
        'status',
    ];
    public function Products()
    {
        return $this->hasMany(Product::class);
    }

    // public function index()
    //     {
    //         $categories = Category::query()
    //             ->with(['products' => function ($q) {
    //                 $q->orderByDesc('id')   // یا ->latest('created_at')
    //                 ->take(4);
    //                 // اگر فقط محصولات قابل‌نمایش/فعال می‌خوای:
    //                 // ->where('is_active', true)
    //                 // ->where('show_on_site', true)
    //                 // ->where(function($w){ $w->whereNull('active_at')->orWhere('active_at','<=',now()); });
    //             }])
    //             // اگر فقط دسته‌های فعال:
    //             // ->where('status', 'active')
    //             ->get();

    //         return $categories; // کالکشن: هر Category شامل collection محصولات محدودشده
    //     }
}

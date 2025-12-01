<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Category;
use Auth;

use View;
abstract class Controller
{
    public function __construct()
    {
        // if(!auth()->user())
            // Auth::loginUsingId("1");
        $data=[];
        if(auth()->user()){
            $cart =Cart::with("product")->where(['user_id'=>auth()->user()->id])->get();
            $data['cart'] = $cart;
        }
        $data['categories'] = $this->get_categories();
        View::share('data', $data);

    }

    public function get_categories(){
        $categories = Category::query()
            ->with(['products' => function ($q) {
                $q->orderByDesc('id')   // یا ->latest('created_at')
                ->take(4);
                // اگر فقط محصولات قابل‌نمایش/فعال می‌خوای:
                // ->where('is_active', true)
                // ->where('show_on_site', true)
                // ->where(function($w){ $w->whereNull('active_at')->orWhere('active_at','<=',now()); });
            }])
            // اگر فقط دسته‌های فعال:
            ->where('status', 'active')
            ->get();
        return $categories;
    }
}

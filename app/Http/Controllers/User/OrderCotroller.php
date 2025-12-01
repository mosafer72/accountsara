<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderCotroller extends Controller
{
    public function orders(){
        $orders=Order::with("items")->orderBy("created_at","desc")->paginate(10);
        return view("Pages.user.orders.list",compact("orders"));
    }

    public function result(Request $request){
        return view("Pages.user.orders.result");
    }

}

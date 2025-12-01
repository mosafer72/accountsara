<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders=Order::orderBy("created_at")->limit(10)->paginate(1);
        return view("Admin.orders.list",compact("orders"));
    }
}

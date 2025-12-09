<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders=Order::orderBy("created_at")->paginate(10);
        return view("Admin.orders.list",compact("orders"));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $last_orders=Order::orderBy("created_at")->limit(10)->get();
        return view("Admin.dashboard",compact("last_orders"));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy("created_at")->paginate(10);
        return view("Admin.orders.list", compact("orders"));
    }


    public function show_more($id)
    {
        $order = Order::findOrFail($id);
        return view("Admin.orders.show_more", compact("order"));
    }


    public function update(Request $request, Order $order)
    {
        dd($order);
        $request->validate([
            'deliverity' => 'required|in:0,1'
        ]);
        
        $order->deliverity = $request->deliverity;
        $order->save();
        return redirect()->route('orders.index')->with('success', 'سفارش با با موفقیت برزرسانی شد.');

    }
}

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


     public function show_more($id){
        $order=Order::findOrFail($id);
        return view("Admin.orders.show_more",compact("order"));
    }


    public function update(Request $request,$id){
        $request->validate([
            "deliverity"=>$request->deliverity
        ]);
        $order=Order::findOrFail($id);
        if(!$order){
            $order->deliverity=$request->deliverity;
            $order->save();
            return redirect()->route('product.show_more',["id"=>$id])->with('success', 'محصول با با موفقیت به سید خرید شما اضافه شد.');
        }else{
            return redirect()->route('product.show_more',["id"=>$id])->withErrors( 'این محصول در سید خرید شما وجود دارد!');
        }
    }
}

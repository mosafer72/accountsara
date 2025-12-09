<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;

class ProductController extends Controller
{
    public function show_more($id){
        $product=Product::findOrFail($id);
        $order_ids=$this->get_order_ids($product->id);
        $users= (count($order_ids) > 0 )?  $this->get_users($order_ids) : []  ;
        $comments=Comment::where("product_id",$id)->get();
        return view("Pages.product.single",compact("product","users","comments"));
    }

    public function get_order_ids($product_id){
        $order_ids=OrderItem::where("product_id",$product_id)->get("order_id");
        return $order_ids;
    }

        public function get_users($order_ids){
        $users_ids= (count($order_ids) > 0 )?  Order::whereIn("id",$order_ids)->get('user_id') : []  ;
        $users= (count($users_ids) > 0 )?  User::whereIn("id",$users_ids)->get() : []  ;
        return $users;
    }
    public function show_by_category($id){
        $category=Category::findOrFail($id);
        $products=Product::where("category_id",$category->id)->paginate(9);
        return view("Pages.product.list",compact("products","category"));
    }



}

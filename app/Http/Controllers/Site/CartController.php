<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;

class CartController extends Controller
{
    public function show()
    {
        if(!auth()->check()){
             return redirect()->back()->withErrors( 'ابتدا وارد اکانت خود شوید.');
        }
        $banners = Cart::orderBy('created_at', 'desc')->get();
        return view('Pages.cart.show', compact('banners'));
    }

    //
    public function add($id,Request $request)
    {
        if(!auth()->check()){
             return redirect()->back()->withErrors( 'ابتدا وارد اکانت خود شوید.');
        }
        $product=Product::findOrFail($id);
        $exrta_items=json_encode([]);
        if(!$product->type){
            $request->validate([
                'email'    => ['required','string','email'],
                'password' => ['required','string','min:6'],
            ]);
            $exrta_items=json_encode([
                'email'=>$request->email,
                'password'=>$request->password,
            ],true);
        }

        $cart=Cart::where(["user_id"=>auth()->user()->id,"product_id" => $product->id])->first();
        if(!$cart){
            // dd($exrta_items);
            try {
                $new_cart=Cart::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $product->id,
                    'qty' => 1,
                    "unit_price" => $product->price,
                    "snapshot" => $exrta_items,
                ]);
            } catch (\Exception $th) {
                echo $th->getMessage();
            }

            return redirect()->route('product.show_more',["id"=>$id])->with('success', 'محصول با با موفقیت به سید خرید شما اضافه شد.');
        }else{
            return redirect()->route('product.show_more',["id"=>$id])->with('warning', 'این محصول در سید خرید شما وجود دارد!');
        }
    }


    public function delete($id)
    {
        if(!auth()->check()){
             return redirect()->back()->withErrors( 'ابتدا وارد اکانت خود شوید.');
        }
       $cart=Cart::where(["user_id"=>auth()->user()->id,"product_id" => $id])->first();
        if($cart){
                $cart->delete();
                return redirect()->back()->with('success', 'بنر با موفقیت ویرایش شد.');
        }else{
            abort(404);
        }


    }
}

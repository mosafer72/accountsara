<?php

namespace App\Http\Controllers\Site;

use App\Models\{Cart, Discount};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CartCouponController extends Controller
{
    public function apply(Request $request) {
        $data = $request->validate([
            'coupon_code' => ['required','string','max:50'],
        ],[
            'coupon_code.required' => 'کد تخفیف را وارد کنید.',
        ]);

        $cart = Cart::where('user_id', Auth::id())->get();
        if(!$cart){
            return back()->withErrors(['coupon' => 'سبد خرید شما خالی است.']);
        }

        $subtotal = (float) $cart->sum(fn($i)=> $i->qty * $i->unit_price);
        $code = trim($data['coupon_code']);
        $coupon = Discount::where('title',$code)->first();
        if(!$coupon || !$coupon->isValidFor($subtotal)){
            return back()->withErrors(['coupon' => 'کد تخفیف معتبر نیست یا شرایط آن برقرار نیست.']);
        }

        $discount = $coupon->discountValueFor($subtotal);
        if($discount <= 0){
            return back()->withErrors(['coupon' => 'مبلغ تخفیف قابل محاسبه نیست.']);
        }

        // ذخیره روی سشن (ساده و امن برای Checkout)
        session([
            'cart_coupon' => [
                'title'     => $coupon->title,
                'type'     => $coupon->type,
                'amount'   => (float)$coupon->amount,
                'discount' => (float)$discount,
            ]
        ]);

        return back()->with('ok', 'کد تخفیف با موفقیت اعمال شد.');
    }

    public function remove(Request $request) {
        $request->session()->forget('cart_coupon');
        return back()->with('ok','کد تخفیف حذف شد.');
    }
}


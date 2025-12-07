<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\{Cart, Order, OrderItem, Coupon};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function createOrder()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->get();
        if ($cart->isEmpty()) {
            return back()->withErrors(['cart' => 'سبد خرید شما خالی است.']);
        }

        return DB::transaction(function () use ($cart, $user) {
            // 1️⃣ محاسبه مبلغ‌ها
            $subtotal = $cart->sum(fn($i) => $i->qty * $i->unit_price);
            die($subtotal);
            $coupon   = session('cart_coupon');
            $discount = $coupon['discount'] ?? 0;
            $total    = max($subtotal - $discount, 0);

            // 2️⃣ ساخت سفارش
            $order = Order::create([
                'user_id'         => $user->id,
                'number'          => Order::generateNumber(),
                'subtotal'        => $subtotal,
                'coupon_discount' => $discount,
                'total'           => $total,
                'coupon_code'     => $coupon['title'] ?? null,
                'currency'        => 'IRR',
                'status'          => 'pending',
            ]);

            // 3️⃣ انتقال آیتم‌های سبد خرید به order_items
            foreach ($cart as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'qty'        => $cartItem->qty,
                    'unit_price' => $cartItem->unit_price,
                    'snapshot'   => json_encode([
                        'title' => $cartItem->product->title,
                        'image' => $cartItem->product->image,
                    ]),
                ]);
            }
            // 4️⃣ پاک‌کردن سبد خرید
            // $cart->map->delete();

            // 5️⃣ درصورت وجود کوپن، ثبت یک‌بار مصرف شدن
            if ($coupon && !empty($coupon['title'])) {
                Discount::where('title', $coupon['title'])->increment('uses');
                session()->forget('cart_coupon');
            }
            // ✅ در نهایت
            return redirect()
                ->route('payment.start', ['order' => $order->id])
                ->with('ok', 'سفارش شما ایجاد شد، در حال هدایت به درگاه پرداخت...');
        });
    }
}

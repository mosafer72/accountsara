<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Coupon;
use App\Services\Payments\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class PaymentController extends Controller
{
    // public function __construct() { $this->middleware('auth')->except(['callback']); }

    /** شروع پرداخت و ریدایرکت به درگاه */
    public function start(Order $order, PaymentGateway $gateway)
    {
        // امنیت: فقط
        // صاحب سفارش
        abort_unless($order->user_id === Auth::id(), 403);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)->withErrors(['pay' => 'این سفارش قابل پرداخت نیست.']);
        }
        $redirectUrl = $gateway->create($order); // رکورد Payment نیز در create ساخته شد
        return redirect()->away($redirectUrl);
    }

    /** کال‌بک/وریفای از درگاه */
    public function callback(string $provider, Request $request, PaymentGateway $gateway)
    {
        // توجه: در VerifyCsrfToken مسیر کال‌بک را از CSRF مستثنی کن (پایین آورد‌ه‌ام)

        $result = $gateway->verify($request);

        // سفارش را با order_id پیدا کن
        $order = Order::where('number', $result->providerOrderId)->firstOrFail();

        // آخرین رکورد payment مرتبط با این سفارش + provider
        $payment = Payment::where('order_id', $order->id)
            ->where('provider', $result->provider)
            ->latest()->first();

        if (!$payment) {
            // اگر پرداختی نیافته شد، یک رکورد بساز تا لاگ داشته باشیم
            $payment = Payment::create([
                'order_id'          => $order->id,
                'provider'          => $result->provider,
                'amount'            => $order->total,
                'status'            => 'init',
            ]);
        }

        // ذخیره اطلاعات برگشتی
        $payment->update([
            'provider_id'       => $result->providerId,
            'provider_order_id' => $result->providerOrderId,
            'provider_track_id' => $result->providerTrackId,
            'callback_payload'  => $result->raw,
        ]);

        if (!$result->success) {
            $payment->update(['status' => 'failed']);
            $order->update(['status' => 'pending']); // یا canceled اگر سناریوت اینه
            return redirect()->route('user.orders.result', "order_id=".$order->number)->withErrors( 'پرداخت ناموفق بود.');
        }

        // موفقیت پرداخت
        DB::transaction(function () use ($order, $payment) {
            $payment->update(['status' => 'succeeded']);
            $order->update(['status' => 'paid']);

            // اگر کوپن اعمال شده بود، مصرفش را ثبت کن
            $couponSess = session('cart_coupon');
            if ($couponSess && !empty($couponSess['code'])) {
                Coupon::where('code', $couponSess['code'])->increment('uses');
                session()->forget('cart_coupon');
            }
        });

        // در اینجا اگر تحویل خودکار داری، می‌تونی شروع کنی

        return redirect()->route('user.orders.result', "order_id=".$order->number)->with('success', 'پرداخت با موفقیت انجام شد.');
    }
}

<?php
// app/Services/Payments/ZarinpalGateway.php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZarinpalGateway implements PaymentGateway
{
    private string $merchant;
    private bool $sandbox;

    public function __construct()
    {
        $this->merchant = (string) config('services.zarinpal.merchant_id');
        $this->sandbox  = (bool) config('services.zarinpal.sandbox', true);
    }

    private function baseUrl(): string
    {
        // v4 REST
        return $this->sandbox
            ? 'https://sandbox.zarinpal.com/pg/v4'
            : 'https://payment.zarinpal.com/pg/v4';
    }

    private function startPayUrl(string $authority): string
    {
        return ($this->sandbox
            ? 'https://sandbox.zarinpal.com/pg/StartPay/'
            : 'https://www.zarinpal.com/pg/StartPay/'
        ) . $authority;
    }

    /** ایجاد تراکنش و دریافت لینک پرداخت */
    public function create(Order $order): string
    {
        // ثبت رکورد پرداخت
        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'zarinpal',
            'amount'   => $order->total,
            'status'   => 'init',
        ]);

        // تبدیل مبلغ به "تومان" اگر قیمت‌ها را ریال ذخیره می‌کنی:
        // $amountToman = (int) round($order->total / 10);
        // اگر قیمت‌هایت همین حالا تومان است:
        $amountToman = (int) round($order->total);

        $callback = route('payment.callback', ['provider' => 'zarinpal']);

        $payload = [
            'merchant_id'  => $this->merchant,
            'amount'       => $amountToman,
            'callback_url' => $callback.$order->number,
            'description'  => 'پرداخت سفارش ' . $order->number,
            'metadata'     => array_filter([
                'email'  => optional($order->user)->email,
                'mobile' => optional($order->user)->phone,
            ]),
            // optional: 'currency' => 'IRT'  // اگر اجباری شد
        ];
        $payment->update(['request_payload' => $payload]);

        $res = Http::withHeaders(['accept'=>'application/json'])
            ->post($this->baseUrl().'/payment/request.json', $payload);

        if (!$res->ok()) {
            $payment->update(['status'=>'failed', 'callback_payload'=>['error'=>$res->json()]]);
            throw new \RuntimeException('Zarinpal request failed (http).');
        }
        $data = $res->json();   // ساختار: ['data'=>['code'=>100,'authority'=>...], 'errors'=>...]
        $dataPart = $data['data'] ?? null;

        if (! $dataPart || (int)($dataPart['code'] ?? 0) !== 100) {
            $payment->update(['status'=>'failed', 'callback_payload'=>$data]);
            $msg = $data['errors']['message'] ?? 'Zarinpal request error';
            throw new \RuntimeException($msg);
        }

        $authority = $dataPart['authority'] ?? null;

        $payment->update([
            'provider_id'       => $authority,      // authority
            'provider_order_id' => $order->number,
            'status'            => 'redirected',
        ]);

        return $this->startPayUrl($authority);
    }

    /** وریفای پس از برگشت از درگاه */
    public function verify(Request $request): PaymentVerifyResult
    {
        // زرین‌پال در callback معمولاً پارامترهای Authority و Status را برمی‌گرداند
        $authority = $request->input('Authority');
        $status    = $request->input('Status');     // OK / NOK

        // برای وریفای، باید مبلغ (تومان) و authority را بفرستیم.
        // order_id را از authority یا از session نداریم، پس باید سفارش را از روی payments پیدا کنیم:
        $payment = Payment::where('provider', 'zarinpal')
            ->where('provider_id', $authority)->latest()->first();

        // اگر پیدا نشد، fallback از order_id داخل url خودت (اگر گذاشته‌ای)
        $order = $payment?->order;

        // اگر نتوانستیم order را پیدا کنیم، شکست می‌زنیم تا لاگ بررسی شود
        if (!$order) {
            return new PaymentVerifyResult(false, 'zarinpal', $authority, null, null, [
                'error' => 'Order not found for this Authority',
                'callback' => $request->all(),
            ]);
        }

        // اگر Status != OK → پرداخت ناموفق/لغو شده
        if (strtoupper((string)$status) !== 'OK') {
            return new PaymentVerifyResult(false, 'zarinpal', $authority, $order->number, null, [
                'callback' => $request->all(),
                'reason' => 'Status not OK',
            ]);
        }

        // مبلغ به تومان:
        $amountToman = (int) round($order->total);

        // Verify
        $payload = [
            'merchant_id' => $this->merchant,
            'amount'      => $amountToman,
            'authority'   => $authority,
        ];

        $vRes = Http::withHeaders(['accept'=>'application/json'])
            ->post($this->baseUrl().'/payment/verify.json', $payload);

        $body = $vRes->json();
        $dataPart = $body['data'] ?? null;

        $ok = $vRes->ok() && $dataPart && in_array((int)($dataPart['code'] ?? 0), [100,101], true);

        return new PaymentVerifyResult(
            success: $ok,
            provider: 'zarinpal',
            providerId: $authority,
            providerOrderId: $order->number,
            providerTrackId: $dataPart['ref_id'] ?? null,   // ref_id = کد رهگیری
            raw: ['callback'=>$request->all(), 'verify'=>$body]
        );
    }
}

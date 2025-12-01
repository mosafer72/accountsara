<?php
// app/Services/Payments/IdpayGateway.php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class IdpayGateway implements PaymentGateway
{
    private string $key;
    private bool $sandbox;

    public function __construct()
    {
        $this->key     = config('services.idpay.key');
        $this->sandbox = (bool) config('services.idpay.sandbox', true);
    }

    public function create(Order $order): string
    {
        // ثبت رکورد پرداخت
        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'idpay',
            'amount'   => $order->total,
            'status'   => 'init',
        ]);

        $callback = route('payment.callback', ['provider' => 'idpay']);

        $payload = [
            'order_id' => $order->number,
            'amount'   => (int) round($order->total), // اگر تومان/ریال داری اینجا مطابق واحدت تنظیم کن
            'name'     => optional($order->user)->name,
            'phone'    => optional($order->user)->phone,
            'mail'     => optional($order->user)->email,
            'desc'     => 'پرداخت سفارش '.$order->number,
            'callback' => $callback,
        ];

        $payment->update(['request_payload' => $payload]);

        $res = Http::withHeaders([
                'X-API-KEY' => $this->key,
                'X-SANDBOX' => $this->sandbox ? '1' : '0',
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.idpay.ir/v1.1/payment', $payload);

        if (!$res->ok()) {
            $payment->update(['status' => 'failed', 'callback_payload' => ['error' => $res->json()]]);
            throw new \RuntimeException('IDPay create payment failed');
        }

        $data = $res->json(); // ['id'=>..., 'link'=>...]
        $payment->update([
            'provider_id'       => $data['id'] ?? null,
            'provider_order_id' => $order->number,
            'status'            => 'redirected',
        ]);

        return $data['link'];
    }

    public function verify(Request $request): PaymentVerifyResult
    {
        // پارامترهای کال‌بک IDPay: id, order_id, track_id, status, amount, date, card_no, hashed_card_no
        $payload = $request->all();

        // وریفای درگاه
        $verifyRes = Http::withHeaders([
                'X-API-KEY' => $this->key,
                'X-SANDBOX' => $this->sandbox ? '1' : '0',
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.idpay.ir/v1.1/payment/verify', [
                'id'       => $payload['id'] ?? null,
                'order_id' => $payload['order_id'] ?? null,
            ]);

        $ok = $verifyRes->ok();
        $body = $verifyRes->json() ?? [];

        return new PaymentVerifyResult(
            success: $ok && (($body['status'] ?? 0) == 100 || ($body['status'] ?? 0) == 101), // 100: موفق
            provider: 'idpay',
            providerId: $payload['id'] ?? null,
            providerOrderId: $payload['order_id'] ?? null,
            providerTrackId: $payload['track_id'] ?? null,
            raw: ['callback'=>$payload, 'verify'=>$body]
        );
    }
}

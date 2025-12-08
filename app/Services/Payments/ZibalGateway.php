<?php
namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZibalGateway implements PaymentGateway
{
    private string $merchant;
    private bool $sandbox;

    public function __construct()
    {
        $this->merchant = (string) config('services.zibal.merchant');
        $this->sandbox  = (bool) config('services.zibal.sandbox', true);
    }

    private function baseUrl(): string
    {
        return $this->sandbox
            ? 'https://sandbox.zibal.ir'
            : 'https://gateway.zibal.ir';
    }

    private function startPayUrl(string $trackId): string
    {
        return ($this->sandbox
            ? 'https://sandbox.zibal.ir/start/'
            : 'https://gateway.zibal.ir/start/'
        ) . $trackId;
    }

    /** ایجاد تراکنش و دریافت لینک پرداخت */
    public function create(Order $order): string
    {
        // ایجاد رکورد پرداخت
        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'zibal',
            'amount'   => $order->total,
            'status'   => 'init',
        ]);

        // اگر مبلغ را تومان ذخیره می‌کنی:
        $amount = (int) round($order->total);

        $callback = route('payment.callback', ['provider' => 'zibal']);

        $payload = [
            'merchant'     => $this->merchant,
            'amount'       => intval($amount."0"),
            'callbackUrl'  => $callback.$order->number,
            'orderId'      => $order->number,
            'description'  => 'پرداخت سفارش ' . $order->number,
        ];

        $payment->update(['request_payload' => $payload]);

        $res = Http::post($this->baseUrl() . '/v1/request', $payload);

        if (! $res->ok()) {
            $payment->update([
                'status' => 'failed',
                'callback_payload' => ['error' => $res->json()],
            ]);
            throw new \RuntimeException('Zibal request failed (http).');
        }

        $body = $res->json();   // { result: 100, trackId: ... }

        if ((int)($body['result'] ?? -1) !== 100) {
            $payment->update([
                'status'=>'failed',
                'callback_payload'=>$body
            ]);
            throw new \RuntimeException($body['message'] ?? 'Zibal request error');
        }

        $trackId = $body['trackId'];

        $payment->update([
            'provider_id'       => $trackId,
            'provider_order_id' => $order->number,
            'status'            => 'redirected',
        ]);

        return $this->startPayUrl($trackId);
    }

    /** وریفای پرداخت */
    public function verify(Request $request): PaymentVerifyResult
    {
        // زیبال در callback فقط trackId می‌دهد
        $trackId = $request->input('trackId');
        $success = $request->input('success');

        $payment = Payment::where('provider', 'zibal')
            ->where('provider_id', $trackId)->first();

        if (! $payment) {
            return new PaymentVerifyResult(false, 'zibal', $trackId, null, null, [
                'error' => 'Payment not found',
                'callback' => $request->all(),
            ]);
        }

        $order = $payment->order;

        if (! $order) {
            return new PaymentVerifyResult(false, 'zibal', $trackId, null, null, [
                'error' => 'Order not found',
                'callback' => $request->all(),
            ]);
        }

        if ((int) $success !== 1) {
            return new PaymentVerifyResult(false, 'zibal', $trackId, $order->number, null, [
                'reason' => 'success=0 from Zibal callback',
                'callback' => $request->all(),
            ]);
        }

        // verify request
        $payload = [
            'merchant' => $this->merchant,
            'trackId'  => $trackId,
        ];

        $vRes = Http::post($this->baseUrl() . '/v1/verify', $payload);
        $body = $vRes->json();

        $ok = $vRes->ok() && isset($body['result']) && in_array((int)$body['result'], [100, 201]);

        return new PaymentVerifyResult(
            success: $ok,
            provider: 'zibal',
            providerId: $trackId,
            providerOrderId: $order->number,
            providerTrackId: $body['refNumber'] ?? null,
            raw: [
                'callback'=>$request->all(),
                'verify'=>$body
            ]
        );
    }
}

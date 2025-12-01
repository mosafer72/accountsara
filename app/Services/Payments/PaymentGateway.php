<?php
// app/Services/Payments/PaymentGateway.php

namespace App\Services\Payments;

use App\Models\Order;
use Illuminate\Http\Request;

interface PaymentGateway
{
    /** ایجاد تراکنش و دریافت لینک پرداخت/ریدایرکت */
    public function create(Order $order): string; // return: redirect_url

    /** وریفای پس از برگشت از درگاه */
    public function verify(Request $request): PaymentVerifyResult;
}

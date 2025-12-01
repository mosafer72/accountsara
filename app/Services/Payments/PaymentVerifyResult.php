<?php
// app/Services/Payments/PaymentVerifyResult.php

namespace App\Services\Payments;

class PaymentVerifyResult
{
    public function __construct(
        public bool   $success,
        public string $provider,
        public ?string $providerId = null,
        public ?string $providerOrderId = null,
        public ?string $providerTrackId = null,
        public array  $raw = []
    ) {}
}

<?php


// app/Services/Sms/KavenegarSmsProvider.php
namespace App\Services\Sms;

use RuntimeException;

class KavenegarSmsProvider implements SmsProvider
{
    public function __construct(private readonly ?string $apiKey = null) {}

    public function send(string $phone, string $message): void
    {
        $key = $this->apiKey ?? config('services.kavenegar.key');
        if (!$key) throw new RuntimeException('Kavenegar API key is missing');

        // بدون وابستگی خارجی: از cURL ساده استفاده می‌کنیم
        $endpoint = "https://api.kavenegar.com/v1/{$key}/sms/send.json";
        $postFields = [
            'receptor' => $phone,
            'message'  => $message,
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => http_build_query($postFields),
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 10,
        ]);
        $res = curl_exec($ch);
        $err = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($err || $code >= 400) {
            throw new RuntimeException('SMS send failed: ' . ($err ?: $res));
        }
    }
}

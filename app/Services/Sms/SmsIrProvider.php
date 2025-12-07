<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;
use RuntimeException;

class SmsIrProvider implements SmsProvider
{
    public function __construct(
        private readonly ?string $apiKey = null,
        private readonly ?string $lineNumber = null,
    ) {}

    /**
     * ارسال پیامک ساده
     */
    public function send(string $phone, string $message): void
    {
        $payload = [
            'lineNumber' => $this->getLineNumber(),
            'message'    => $message,
            'mobile'     => $phone,
        ];

        $response = $this->request('https://api.sms.ir/v1/send', $payload);

        // اگر status != 1 بود، فقط لاگ کن؛ Exception پرتاب نکن
        if (($response['status'] ?? 0) !== 1) {
            Log::warning('Sms.ir send failed', [
                'mobile'   => $phone,
                'payload'  => $payload,
                'response' => $response,
            ]);
        }
    }

   
    public function sendOtp(
        string $phone,
        string $code,
        int $templateId,
        string $parameterName = 'code'
    ): void {
        $payload = [
            'mobile'     => $phone,
            'templateId' => $templateId,
            'parameters' => [
                [
                    'name'  => $parameterName, // باید دقیقا همون Name قالب باشه
                    'value' => $code,
                ],
            ],
        ];

        $response = $this->request('https://api.sms.ir/v1/send/verify', $payload);

        if (($response['status'] ?? 0) !== 1) {
            Log::warning('Sms.ir OTP failed', [
                'mobile'   => $phone,
                'payload'  => $payload,
                'response' => $response,
            ]);
        }
    }

    /**
     * درخواست عمومی CURL به Sms.ir
     */
    private function request(string $url, array $payload): array
    {
        $apiKey = $this->getApiKey();

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'X-API-KEY: ' . $apiKey,
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
        ]);

        $raw  = curl_exec($ch);
        $err  = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // خطای شبکه / CURL → لاگ، نه Exception
        if ($err || $raw === false) {
            Log::error('Sms.ir CURL error', [
                'error' => $err,
                'code'  => $code,
                'url'   => $url,
            ]);

            return ['status' => 0, 'message' => 'curl_error'];
        }

        $decoded = json_decode($raw, true);

        if (! is_array($decoded)) {
            Log::error('Sms.ir invalid JSON response', [
                'raw'  => $raw,
                'code' => $code,
                'url'  => $url,
            ]);

            return ['status' => 0, 'message' => 'invalid_json'];
        }

        return $decoded;
    }

    /**
     * گرفتن API Key از env + تمیز کردن کوتیشن / فاصله‌ها
     */
    private function getApiKey(): string
    {
        $key = $this->apiKey ?? config('services.smsir.api_key');

        $key = trim((string) $key, " \t\n\r\0\x0B\"'");

        if ($key === '') {
            throw new RuntimeException('Sms.ir API key is missing');
        }

        return $key;
    }

    /**
     * گرفتن شماره خط از env + تمیز کردن
     */
    private function getLineNumber(): string
    {
        $line = $this->lineNumber ?? config('services.smsir.line_number');

        $line = trim((string) $line, " \t\n\r\0\x0B\"'");

        if ($line === '') {
            throw new RuntimeException('Sms.ir line number is missing');
        }

        return $line;
    }
}

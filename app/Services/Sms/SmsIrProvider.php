<?php

namespace App\Services\Sms;

use RuntimeException;

class SmsIrProvider implements SmsProvider
{
    public function __construct(
        private readonly ?string $apiKey = null,
        private readonly ?string $lineNumber = null
    ) {}

    /**
     * ارسال پیامک ساده با Sms.ir (نسخه V1 API)
     */
    public function send(string $phone, string $message): void
    {
        $key = trim($this->apiKey ?? config('services.smsir.api_key'), "\"' ");
        $line = trim($this->lineNumber ?? config('services.smsir.line_number'), "\"' ");
        die(config('services.smsir.api_key') ."////////////////".$line);
        if (!$key)  throw new RuntimeException('Sms.ir API key is missing');
        if (!$line) throw new RuntimeException('Sms.ir line number is missing');

        $endpoint = "https://api.sms.ir/v1/send";

        $payload = [
            "lineNumber" => $line,
            "message"    => $message,
            "mobile"     => $phone,
        ];

        $response = $this->curlRequest($endpoint, $payload, $key);

        if (!isset($response['status']) || $response['status'] !== 1) {
            throw new RuntimeException("Sms.ir send failed: " . json_encode($response));
        }
    }

    /**
     * ارسال پیامک OTP از طریق قالب (TemplateId)
     */
    public function sendOtp(string $phone, string $code, int $templateId): void
    {
        $key = $this->apiKey ?? config('services.smsir.api_key');
        if (!$key) throw new RuntimeException('Sms.ir API key is missing');

        $endpoint = "https://api.sms.ir/v1/send/verify";

        $payload = [
            "mobile"     => $phone,
            "templateId" => $templateId,
            "parameters" => [
                [
                    "name"  => "code",
                    "value" => $code,
                ]
            ]
        ];

        $response = $this->curlRequest($endpoint, $payload, $key);

        if (!isset($response['status']) || $response['status'] !== 1) {
            throw new RuntimeException("Sms.ir OTP failed: " . json_encode($response));
        }
    }

    /**
     * درخواست CURL عمومی
     */
    private function curlRequest(string $url, array $payload, string $apiKey): array
    {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => json_encode($payload),
            CURLOPT_HTTPHEADER      => [
                'Content-Type: application/json',
                'x-api-key: ' . $apiKey
            ],
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 10,
        ]);

        $res  = curl_exec($ch);
        $err  = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($err || $code >= 400) {
            throw new RuntimeException('Sms.ir request failed: ' . ($err ?: $res));
        }

        return json_decode($res, true) ?: [];
    }
}

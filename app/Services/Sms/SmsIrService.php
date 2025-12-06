<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsIrService
{
    private string $apiKey;
    private string $lineNumber;

    public function __construct()
    {
        $this->apiKey = config('services.smsir.api_key');
        $this->lineNumber = config('services.smsir.line_number');
    }

    /**
     * ارسال پیامک ساده
     */
    public function sendSms(string $mobile, string $message)
    {
        $url = "https://api.sms.ir/v1/send";

        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey
        ])->post($url, [
            "lineNumber" => $this->lineNumber,
            "message"    => $message,
            "mobile"     => $mobile
        ]);

        return $response->json();
    }

    /**
     * ارسال کد تأیید (OTP)
     */
    public function sendOtp(string $mobile, string $code, int $templateId)
    {
        $url = "https://api.sms.ir/v1/send/verify";

        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey
        ])->post($url, [
            "mobile"     => $mobile,
            "templateId" => $templateId,
            "parameters" => [
                [
                    "name"  => "code",
                    "value" => $code
                ]
            ]
        ]);

        return $response->json();
    }
}

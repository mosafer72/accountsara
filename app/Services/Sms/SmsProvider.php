<?php



// app/Services/Sms/SmsProvider.php
namespace App\Services\Sms;

interface SmsProvider {
    /**
     * @param string $phone شماره مقصد (با فرمت نرمال شده)
     * @param string $message متن پیامک
     * @return void
     * @throws \RuntimeException در صورت خطا
     */
    public function send(string $phone, string $message): void;
}

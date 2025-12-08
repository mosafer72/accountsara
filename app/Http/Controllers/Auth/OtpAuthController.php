<?php

// app/Http/Controllers/Auth/OtpAuthController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Services\Sms\SmsProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class OtpAuthController extends Controller
{
    const OTP_LENGTH = 5;          // 4-6
    const OTP_TTL    = 180;        // ثانیه (اینجا 3 دقیقه)
    const MAX_ATTEMPTS_PER_CODE = 5;
    const RESEND_WINDOW_SECONDS = 60; // حداقل فاصله درخواست مجدد

    public function showPhoneForm()
    {
        return view('Pages.auth.phone'); // فرم گرفتن شماره
    }

    public function send(Request $request, SmsProvider $sms)
    {
        // die("false");
        // ولیدیشن شماره
        $request->validate([
            'phone' => ['required','string','min:8','max:20'],
        ], [
            'phone.required' => 'شماره موبایل الزامی است.',
        ]);

        $phone = $this->normalizePhone($request->input('phone'));

        // ریت‌لیمیت براساس شماره+IP
        $key = 'otp_send:' . $phone . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, $perMinute = 1)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'phone' => "درخواست زیاد بود، لطفاً {$seconds} ثانیه دیگر تلاش کنید.",
            ]);
        }

        // جلوگیری از ارسال‌های خیلی پی‌درپی
        $last = Otp::where('phone', $phone)->latest()->first();
        if ($last && $last->created_at->diffInSeconds(now()) < self::RESEND_WINDOW_SECONDS) {
            $wait = self::RESEND_WINDOW_SECONDS - $last->created_at->diffInSeconds(now());
            throw ValidationException::withMessages([
                'phone' => "لطفاً {$wait} ثانیه صبر کنید سپس دوباره درخواست دهید.",
            ]);
        }

        // ساخت کد و ذخیره هش
        $code = $this->generateNumericCode(self::OTP_LENGTH);
        $otp = Otp::create([
            'phone'      => $phone,
            'code_hash'  => Hash::make($code),
            'purpose'    => 'login',
            'attempts'   => 0,
            'expires_at' => now()->addSeconds(self::OTP_TTL),
        ]);
        // ارسال پیامک
        $message = "کد ورود شما: {$code}\nاعتبار: " . (self::OTP_TTL/60) . " دقیقه";
        try {
            $sms->sendOtp($phone, $code,"922288","code");
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'phone' => "لطفاً {} ثانیه صبر کنید سپس دوباره درخواست دهید.",
            ]);
        }
        session('code',$code);
        RateLimiter::hit($key, 60); // پنالتی 60 ثانیه‌ای

        // نمایش فرم وارد کردن کد
        return redirect()
            ->route('otp.verify.form')
            ->with([
                'otp_phone' => $phone,
                'otp_expires_at' => $otp->expires_at->toIso8601String(),
            ]);
    }

    public function showVerifyForm(Request $request)
    {
        $phone = session('otp_phone');
        if (!$phone) return redirect()->route('otp.phone.form');

        return view('Pages.auth.verify',compact("phone"));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => ['required','string','min:8','max:20'],
            'code'  => ['required','digits_between:4,6'],
        ], [
            'code.required' => 'کد الزامی است.',
        ]);

        $phone = $this->normalizePhone($request->input('phone'));
        $code  = $request->input('code');

        // آخرین OTP معتبر برای این شماره
        $otp = Otp::where('phone', $phone)->latest()->first();
        if (!$otp) {
            throw ValidationException::withMessages(['code' => 'کد یافت نشد. دوباره درخواست دهید.']);
        }

        if ($otp->isExpired()) {
            throw ValidationException::withMessages(['code' => 'کد منقضی شده است. دوباره درخواست دهید.']);
        }

        if ($otp->attempts >= self::MAX_ATTEMPTS_PER_CODE) {
            throw ValidationException::withMessages(['code' => 'تعداد تلاش‌ها به حد مجاز رسید. کد جدید بگیرید.']);
        }

        // بررسی کد
        if (!Hash::check($code, $otp->code_hash)) {
            $otp->increment('attempts');
            throw ValidationException::withMessages(['code' => 'کد نادرست است.']);
        }

        // موفق → یوزر را پیدا/بساز
        $user = User::where('phone', $phone)->first();
        if (!$user) {
            $user = User::create([
                // 'name'     => 'کاربر ' . Str::substr($phone, -4),
                'phone'    => $phone,
                'password' => Hash::make(Str::random(32)), // پسورد داخلی برای سازگاری
                'email'    => null, // اگر ایمیل نمی‌خواهی
            ]);
        }

        // پاک کردن OTPهای قبلی این شماره
        Otp::where('phone', $phone)->delete();

        // لاگین و ریدایرکت
        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->back()
            ->with('ورود موفق!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('otp.phone.form');
    }

    // — Helpers —

    private function normalizePhone(string $phone): string
    {
        // همه‌چیز غیر عددی را حذف می‌کنیم
        $digits = preg_replace('/\D+/', '', $phone ?? '');
        // اگر ایران: تبدیل 09.. به 989..
        if (str_starts_with($digits, '09')) {
            $digits = '98' . substr($digits, 1);
        } elseif (str_starts_with($digits, '9') && strlen($digits) === 10) {
            $digits = '98' . $digits;
        }
        return $digits;
    }

    private function generateNumericCode(int $len = 5): string
    {
        $min = (int) str_pad('1', $len, '0');     // 10000
        $max = (int) str_pad('',  $len, '9');     // 99999
        return (string) random_int($min, $max);
    }

}



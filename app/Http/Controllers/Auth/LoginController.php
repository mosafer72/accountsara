<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Pages.auth.login');
    }

    public function login(Request $request)
    {
        // ولیدیشن ورودی
        $request->validate([
            'email'    => ['required','string','email'],
            'password' => ['required','string','min:6'],
            'remember' => ['nullable','boolean'],
        ]);

        // کلید ریت‌لیمیت (ایمیل + آی‌پی)
        $key = Str::lower($request->input('email')).'|'.$request->ip();

        // اگر بیش از حد تلاش شده باشد
        if (RateLimiter::tooManyAttempts($key, $perMinute = 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withErrors([
                    'email' => "تعداد تلاش‌ها زیاد شد. لطفاً {$seconds} ثانیه دیگر دوباره امتحان کنید.",
                ])
                ->onlyInput('email');
        }

        // تلاش برای ورود
        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // موفق: ریست کانتر ریت‌لیمیت + امن‌سازی سشن
            RateLimiter::clear($key);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        // ناموفق: افزایش کانتر
        RateLimiter::hit($key, $decaySeconds = 60);

        return back()
            ->withErrors(['email' => 'ایمیل یا رمز عبور نادرست است.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();                        // خروج کاربر
        $request->session()->invalidate();     // باطل‌کردن سشن
        $request->session()->regenerateToken();// رجنریت CSRF

        return redirect()->back();
    }
}

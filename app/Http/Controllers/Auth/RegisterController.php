<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // ولیدیشن ورودی‌ها
        $validated = $request->validate([
            'name'                  => ['required','string','max:100'],
            'email'                 => ['required','string','lowercase','email','max:255','unique:users,email'],
            'password'              => ['required','string', Password::defaults(), 'confirmed'],
            'password_confirmation' => ['required','string'],
            'terms'                 => ['accepted'], // تیک قوانین
        ],[
            'name.required' => 'نام الزامی است.',
            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'ایمیل معتبر نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.confirmed' => 'تکرار رمز مطابقت ندارد.',
            'terms.accepted' => 'لطفاً قوانین را بپذیرید.',
        ]);
        // ایجاد کاربر
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // اگر ایمیل‌وریفای می‌خواهید: event(new Registered($user)); و middleware('verified') روی روت‌ها
        event(new Registered($user));

        // ورود خودکار و ریدایرکت
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))->with('status', 'خوش آمدید!');
    }
}

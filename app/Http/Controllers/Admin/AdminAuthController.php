<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string|min:6',
        ]);

        // فقط کاربر با نقش admin میتونه لاگین کنه
        if(Auth::attempt( $credentials)){
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success','خوش آمدید.');
        }

        return back()->withErrors([
            'email'=>'ایمیل یا رمز عبور اشتباه است.'
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}

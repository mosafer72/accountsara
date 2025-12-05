<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('Admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('Admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:11|max:11|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin ?? false,
        ]);

        return redirect()->route('Admin.users.index')->with('success', 'کاربر با موفقیت ایجاد شد.');
    }

    public function edit(User $user)
    {
        return view('Admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'is_admin' => $request->is_admin ?? false,
        ]);

        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('Admin.users.index')->with('success', 'کاربر با موفقیت ویرایش شد.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('Admin.users.index')->with('success', 'کاربر حذف شد.');
    }

    // ✅ ورود به عنوان کاربر
    public function loginAs(User $user)
    {
        Auth::logout();
        Auth::login($user);
        return redirect('/')->with('success', 'شما وارد حساب کاربر شدید.');
    }
}

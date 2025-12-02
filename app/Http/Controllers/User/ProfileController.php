<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        return view("Pages.user.profile",compact("user"));
    }



    // به‌روزرسانی دسته
    public function update(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:255',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->name=$request->name;
        $user->save();
        return view("Pages.user.profile",compact("user"))
                         ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

}

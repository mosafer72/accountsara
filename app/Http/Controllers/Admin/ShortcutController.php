<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shortcut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ShortcutController extends Controller
{
    /**
     * نمایش لیست اسلایدرها
     */
    public function index()
    {
        $shortcuts = Shortcut::latest()->get();
        return view('Admin.shortcuts.index', compact('shortcuts'));
    }

    /**
     * فرم ایجاد اسلایدر جدید
     */
    public function create()
    {
        return view('Admin.shortcuts.create');
    }

    /**
     * ذخیره اسلایدر جدید در دیتابیس
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'option' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
             $imagePath = $request->file('image')->store('shortcuts', 'public');
        }
        // آپلود تصویر

        // ذخیره رکورد در دیتابیس
        Shortcut::create([
            'title' => $request->title,
            'option' => $request->option,
            'image' => isset($imagePath) ?  $imagePath : "",
            'link' => $request->link,
            'status' => true,
        ]);

        return redirect()->route('admin.shortcuts.index')->with('success', 'اسلایدر با موفقیت ایجاد شد.');
    }

    /**
     * فرم ویرایش اسلایدر
     */
    public function edit(Shortcut $shortcut)
    {
        return view('Admin.shortcuts.edit', compact('shortcut'));
    }

    /**
     * بروزرسانی اطلاعات اسلایدر
     */
    public function update(Request $request, Shortcut $shortcut)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'option' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url',
        ]);

        $data = $request->only(['title', 'subtitle', 'link']);

        // در صورت وجود عکس جدید، عکس قبلی حذف و جایگزین شود
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($shortcut->image);
            $data['image'] = $request->file('image')->store('shortcuts', 'public');
        }

        $shortcut->update($data);

        return redirect()->route('admin.shortcuts.index')->with('success', 'اسلایدر با موفقیت ویرایش شد.');
    }

    /**
     * حذف اسلایدر
     */
    public function destroy(Shortcut $shortcut)
    {
        Storage::disk('public')->delete($shortcut->image);
        $shortcut->delete();

        return redirect()->route('admin.shortcuts.index')->with('success', 'اسلایدر حذف شد.');
    }

    /**
     * تغییر وضعیت فعال/غیرفعال
     */
    public function toggleStatus(Shortcut $shortcut)
    {
        $shortcut->status = !$shortcut->status;
        $shortcut->save();

        return back()->with('success', 'وضعیت اسلایدر تغییر کرد.');
    }
}

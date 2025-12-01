<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SliderController extends Controller
{
    /**
     * نمایش لیست اسلایدرها
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('Admin.sliders.index', compact('sliders'));
    }

    /**
     * فرم ایجاد اسلایدر جدید
     */
    public function create()
    {
        return view('Admin.sliders.create');
    }

    /**
     * ذخیره اسلایدر جدید در دیتابیس
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url',
        ]);

        // آپلود تصویر
        $imagePath = $request->file('image')->store('sliders', 'public');

        // ذخیره رکورد در دیتابیس
        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'link' => $request->link,
            'status' => true,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلایدر با موفقیت ایجاد شد.');
    }

    /**
     * فرم ویرایش اسلایدر
     */
    public function edit(Slider $slider)
    {
        return view('Admin.sliders.edit', compact('slider'));
    }

    /**
     * بروزرسانی اطلاعات اسلایدر
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url',
        ]);

        $data = $request->only(['title', 'subtitle', 'link']);

        // در صورت وجود عکس جدید، عکس قبلی حذف و جایگزین شود
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slider->image);
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلایدر با موفقیت ویرایش شد.');
    }

    /**
     * حذف اسلایدر
     */
    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image);
        $slider->delete();

        return redirect()->route('Admin.sliders.index')->with('success', 'اسلایدر حذف شد.');
    }

    /**
     * تغییر وضعیت فعال/غیرفعال
     */
    public function toggleStatus(Slider $slider)
    {
        $slider->status = !$slider->status;
        $slider->save();

        return back()->with('success', 'وضعیت اسلایدر تغییر کرد.');
    }
}

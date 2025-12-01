<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    // نمایش همه دسته‌بندی‌ها
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('Admin.categories.index', compact('categories'));
    }

    // نمایش فرم ایجاد دسته‌بندی جدید
    public function create()
    {

        return view('Admin.categories.create');
    }

    // ذخیره دسته‌بندی جدید
    public function store(Request $request)
    {

        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'دسته‌بندی جدید با موفقیت افزوده شد.');
    }

    // نمایش یک دسته خاص
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('Admin.categories.show', compact('category'));
    }

    // نمایش فرم ویرایش دسته
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('Admin.categories.edit', compact('category'));
    }

    // به‌روزرسانی دسته
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

    // حذف دسته
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('Admin.categories.index')
                         ->with('success', 'دسته‌بندی حذف شد.');
    }
}

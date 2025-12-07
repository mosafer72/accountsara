<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(){
        Auth::loginUsingId(1);
    }
    public function index()
    {
        $products = Product::with('category', 'user')->latest()->paginate(10);
        return view('Admin.products.index', data: compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('Admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'type'      => 'required|in:0,1'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('products', 'public');
        }

        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'image' => $imagePath,
            'banner' => isset($bannerPath) ? $bannerPath : "",
            'is_active' => $request->has('is_active'),
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'type' => $request->type,
            // 'active_at' => $request->active_at,
            'show_on_site' => $request->has('show_on_site'),
            'discount_percent' => $request->discount_percent ?? 0
        ]);

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت اضافه شد.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('Admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'type'      => 'required|in:0,1'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
         if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('products', 'public');
            $product->banner = $bannerPath;
        }

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
            'category_id' => $request->category_id,
            'type' => $request->type,
            // 'active_at' => $request->active_at,
            'show_on_site' => $request->has('show_on_site'),
            'discount_percent' => $request->discount_percent ?? 0
        ]);

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ویرایش شد.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'محصول حذف شد.');
    }
}

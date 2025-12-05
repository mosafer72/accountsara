<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Category;
use Auth;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(){
        Auth::loginUsingId(1);
    }
    public function index()
    {
        $discounts = Discount::with(['category','user'])->latest()->get();
        return view('Admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('Admin.discounts.create', compact('categories','products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'boolean',
        ]);

        $data['user_id'] = auth()->id();

        $discount = Discount::create($data);

        if(!empty($data['products'])){
            $discount->products()->sync($data['products']);
        }

        return redirect()->route('admin.discounts.index')->with('success', 'تخفیف ایجاد شد.');
    }

    public function edit(Discount $discount)
    {
        $categories = Category::all();
        $products = Product::all();
        $selectedProducts = $discount->products->pluck('id')->toArray();

        return view('Admin.discounts.edit', compact('discount','categories','products','selectedProducts'));
    }

    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'boolean',
        ]);

        $discount->update($data);

        if(!empty($data['products'])){
            $discount->products()->sync($data['products']);
        } else {
            $discount->products()->detach();
        }

        return redirect()->route('admin.discounts.index')->with('success', 'تخفیف بروزرسانی شد.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'تخفیف حذف شد.');
    }

    public function toggle(Discount $discount)
    {
        $discount->status = !$discount->status;
        $discount->save();
        return redirect()->route('admin.discounts.index')->with('success', 'وضعیت تخفیف تغییر یافت.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user', 'product', 'replies')->whereNull('parent_id')->latest()->get();
        return view('Admin.comments.index', compact('comments'));
    }

    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        $parentId = request()->get('parent_id');
        return view('Admin.comments.create', compact('product', 'parentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => true
        ]);

        return redirect()->back()->with('success', 'کامنت با موفقیت ثبت شد.');
    }

    public function edit(Comment $comment)
    {
        return view('Admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $comment->update($request->only('title','content'));

        return redirect()->route('admin.comments.index')->with('success', 'کامنت با موفقیت ویرایش شد.');
    }

    public function toggle(Comment $comment)
    {
        $comment->update(['is_active' => !$comment->is_active]);
        return redirect()->back()->with('success', 'وضعیت کامنت با موفقیت تغییر یافت.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'کامنت با موفقیت حذف شد.');
    }
}

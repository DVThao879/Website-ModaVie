<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    const PATH_VIEW = 'admin.comments.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Comment::class);
        $data = Product::with('comments')
            ->withCount('comments')
            ->orderBy('id', 'desc')
            ->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['comments.user'])->findOrFail($id);

        if ($product->comments->isEmpty()) {
            return back()->with('warning', 'Không có bình luận nào cho sản phẩm này');
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('product'));
    }
}

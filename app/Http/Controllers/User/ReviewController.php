<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    
    public function store(Request $request)
    {
        if(!Auth::check()){
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để bình luận.'); 
          }
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5', // Kiểm tra rating
        ]);
     
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'content' => $request->content,
            'rating' => $request->rating, 
            'is_active' => true,
        ]);
    
        return redirect()->back()->with('success', 'Bình luận đã được thêm.');
    }
    
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(){
        $blogs=Blog::query()->where('is_active',1)->with('user')->paginate(9);
        return view('client.show.blog',compact('blogs'));
    }
    public function detail($id) {
        $blog = Blog::query()->where('id', $id)->with('user')->first();
        $blog->increment('view');
    
        $voucher = Voucher::where('is_active', 1)->inRandomOrder()->first();
    
        $previousBlog = Blog::where('id', '<', $blog->id)->where('is_active', 1)->orderBy('id', 'desc')->first();
        $nextBlog = Blog::where('id', '>', $blog->id)->where('is_active', 1)->orderBy('id', 'asc')->first();
        
        $recentBlogs = Blog::where('is_active', 1)
            ->where('id', '!=', $id) 
            ->orderBy('created_at', 'desc') 
            ->take(5) 
            ->get();
    
        return view('client.show.blog_detail', compact('blog', 'previousBlog', 'nextBlog', 'recentBlogs', 'voucher'));
    }
    
    
    
}

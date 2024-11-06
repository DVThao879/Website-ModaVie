<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    const PATH_VIEW = 'admin.blogs.';
    const PATH_UPLOAD = 'blogs';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Blog::class);
        $data = Blog::orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Blog::class);
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        if ($request->hasFile('img_avt')) {
            $data['img_avt'] = Storage::put('blogs', $request->file('img_avt'));
        } else {
            $data['img_avt'] = '';
        }
        Blog::create($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $this->authorize('view', $blog);
        return view(self::PATH_VIEW.__FUNCTION__, compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
        return view(self::PATH_VIEW . __FUNCTION__, compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->except('img_avt');

        if ($request->hasFile('img_avt')) {
            if ($blog->img_avt && Storage::exists($blog->img_avt)) {
                Storage::delete($blog->img_avt);
            }

            $data['img_avt'] = Storage::put('blogs', $request->file('img_avt'));
        } else {
            $data['img_avt'] = $blog->img_avt;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);
        if(!empty($blog->img_avt) && Storage::exists($blog->img_avt)){
            Storage::delete($blog->img_avt);
        }
        $blog->delete();
        return back()->with('success', 'Xóa thành công');
    }
}

<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ChangeActiveController extends Controller
{
    // Category
    public function changeActiveCategory(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Danh mục không tìm thấy'], 404);
        }

        // Cập nhật trạng thái is_active
        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $category->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục thành công',
                'newStatus' => $newActive,
                'category' => $category
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllCategory(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }

        $id = $request->id; // Lấy ID từ request
        $active = $request->is_active;
        // Kiểm tra xem có ID nào không
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Category::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái danh mục thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated // Trả về số lượng category được cập nhật
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có danh mục nào được cập nhật'], 404);
    }

    // Product
    public function changeActiveProduct(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Sản phẩm không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $product->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái sản phẩm thành công',
                'newStatus' => $newActive,
                'category' => $product
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllProduct(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }
        
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Product::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái sản phẩm thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có sản phẩm nào được cập nhật'], 404);
    }

    // Account
    public function changeActiveAccount(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $account = User::find($id);
        if (!$account) {
            return response()->json(['status' => false, 'message' => 'Tài khoản không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $account->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái tài khoản thành công',
                'newStatus' => $newActive,
                'category' => $account
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllAccount(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }

        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = User::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái tài khoản thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có tài khoản nào được cập nhật'], 404);
    }

    // Blog
    public function changeActiveBlog(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['status' => false, 'message' => 'Bài viết không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $blog->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái bài viết thành công',
                'newStatus' => $newActive,
                'blog' => $blog
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllBlog(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }

        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Blog::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái bài viết thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có bài viết nào được cập nhật'], 404);
    }

    // Banner
    public function changeActiveBanner(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['status' => false, 'message' => 'Banner không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $banner->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái banner thành công',
                'newStatus' => $newActive,
                'banner' => $banner
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllBanner(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }
        
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Banner::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái banner thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có banner nào được cập nhật'], 404);
    }

    // Voucher
    public function changeActiveVoucher(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $voucher = Voucher::find($id);
        if (!$voucher) {
            return response()->json(['status' => false, 'message' => 'Voucher không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $voucher->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái voucher thành công',
                'newStatus' => $newActive,
                'voucher' => $voucher
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllVoucher(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }
        
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Voucher::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái voucher thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có voucher nào được cập nhật'], 404);
    }

    // Comment
    public function changeActiveComment(Request $request)
    {
        $id = $request->id;
        $isActive = $request->is_active;

        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['status' => false, 'message' => 'Bình luận không tìm thấy'], 404);
        }

        $newActive = $isActive == 1 ? 0 : 1;
        $updated = $comment->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái bình luận thành công',
                'newStatus' => $newActive,
                'comment' => $comment
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cập nhật thất bại'], 500);
        }
    }

    public function changeActiveAllComment(Request $request)
    {
        if (auth()->user()->role != 2) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }
        
        $id = $request->id;
        $active = $request->is_active;
        if (empty($id) || !is_array($id)) {
            return response()->json(['status' => false, 'message' => 'ID không hợp lệ'], 400);
        }

        $newActive = $active == 0 ? 1 : 0;

        $updated = Comment::whereIn('id', $id)->update(['is_active' => $newActive]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái bình luận thành công',
                'newStatus' => $newActive,
                'updatedCount' => $updated
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Không có bình luận nào được cập nhật'], 404);
    }
}


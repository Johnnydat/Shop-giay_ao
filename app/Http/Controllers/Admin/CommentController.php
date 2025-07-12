<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Quản lý Bình luận';

        $query = Comment::with(['user', 'product', 'replies'])
            ->withCount('replies')
            ->whereNull('parent_id') // Chỉ lấy bình luận gốc
            ->latest();

        // Tìm kiếm
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('username', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

       
        $comments = $query->paginate(15)->withQueryString();

        return view('admin.comments.index', compact('title', 'comments'));
    }

    public function toggleStatus(Comment $comment)
    {
        $newStatus = $comment->status === 'active' ? 'hidden' : 'active';
        $comment->update(['status' => $newStatus]);

        $action = $newStatus === 'active' ? 'hiển thị' : 'ẩn';
        return back()->with('success', "Đã {$action} bình luận #{$comment->id}");
    }

    /**
     * Xóa bình luận
     */
    public function destroy(Comment $comment)
    {
        // Xóa tất cả các phản hồi trước
        $comment->replies()->delete();

        // Sau đó xóa bình luận chính
        $comment->delete();

        return back()->with('success', "Đã xóa bình luận #{$comment->id} và tất cả phản hồi");
    }
}

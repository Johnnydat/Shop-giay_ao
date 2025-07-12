<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Quản lý Người dùng';

        // Lấy danh sách người dùng với phân trang
        $users = User::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('title', 'users'));
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        $title = "Chi tiết Người dùng: {$user->name}";

        return view('admin.users.show', compact('title', 'user'));
    }

    public function lock(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không thể khóa tài khoản của chính mình.');
        }

        try {
            $user->status = $user->status === 'active' ? 'banned' : 'active';
            $user->save();
            $message = $user->status === 'active' ? 'Tài khoản đã được mở khóa.' : 'Tài khoản đã bị khóa.';
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi cập nhật trạng thái tài khoản.');
        }
    }
}

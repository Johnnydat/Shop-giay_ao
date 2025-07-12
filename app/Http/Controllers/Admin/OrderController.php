<?php

// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        $statuses = Order::STATUSES;

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        $statuses = Order::STATUSES;

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $currentStatus = $order->status;
        $newStatus = $request->status;

        // Danh sách các trạng thái không thể thay đổi sau khi đạt đến
        $immutableStatuses = ['delivered', 'cancelled'];

        // Rule: Không cho phép sửa nếu đã ở trạng thái kết thúc
        if (in_array($currentStatus, $immutableStatuses)) {
            return back()->with('error', 'Không thể thay đổi trạng thái đơn hàng đã kết thúc.');
        }

        // Rule: Chặn chuyển ngược về trạng thái trước đó
        $allowedTransitions = [
            'pending'    => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped'    => ['delivered', 'cancelled'],
        ];

        if (!in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
            return back()->with('error', 'Không thể chuyển từ "' . Order::STATUSES[$currentStatus]['text'] . '" sang "' . Order::STATUSES[$newStatus]['text'] . '".');
        }

        // Cập nhật trạng thái mới
        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã xóa');
    }
}

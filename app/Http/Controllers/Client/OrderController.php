<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this import

class OrderController extends Controller
{
    use AuthorizesRequests; // Include this trait

    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure the user can view this order
        $this->authorize('view', $order);
        $order->load('items.product');
        return view('client.orders.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        // Ensure the user can update the order
        $this->authorize('update', $order);

        if ($order->status === 'shipped') {
            $order->update(['status' => 'delivered']);
            return back()->with('success', 'Đã xác nhận nhận hàng thành công');
        }

        return back()->with('error', 'Chỉ có thể xác nhận đơn hàng đang giao');
    }

    public function cancel(Order $order)
    {
        // Ensure the user can update the order
        $this->authorize('update', $order);

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);

            // Hoàn trả số lượng sản phẩm nếu cần
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            return back()->with('success', 'Đã hủy đơn hàng thành công');
        }

        return back()->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái chờ xử lý');
    }
}

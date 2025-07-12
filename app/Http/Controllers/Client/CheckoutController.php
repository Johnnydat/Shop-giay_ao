<?php
    namespace App\Http\Controllers\Client;

    use App\Http\Controllers\Controller;
    use App\Models\Cart;
    use App\Models\Order;
    use App\Models\OrderItem;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    class CheckoutController extends Controller
    {
        public function show()
        {
            $cartItems = Auth::user()->carts()->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
            }

            // Kiểm tra tồn kho
            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product->stock) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Sản phẩm ' . $item->product->name . ' chỉ còn ' . $item->product->stock . ' sản phẩm');
                }
            }

            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            return view('client.checkout.show', compact('cartItems', 'total'));
        }

        public function placeOrder(Request $request)
        {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string',
                'payment_method' => 'required|string|in:cash,bank_transfer,credit_card',
            ]);

            $cartItems = Auth::user()->carts()->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
            }

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'ORD-' . Str::upper(Str::random(10)),
                'total_amount' => $cartItems->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                }),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'notes' => $request->notes,
            ]);

            // Thêm sản phẩm vào đơn hàng và cập nhật tồn kho
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Giảm số lượng tồn kho
                $item->product->decrement('stock', $item->quantity);
            }

            // Xóa giỏ hàng
            Auth::user()->carts()->delete();

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Đặt hàng thành công');
        }

        public function confirmation(Order $order)
        {
            if ($order->user_id !== Auth::id()) {
                abort(403);
            }
            $statuses = Order::STATUSES;
            // dd($statuses);

            return view('client.order.confirmation', compact('order', 'statuses'));
        }
    }

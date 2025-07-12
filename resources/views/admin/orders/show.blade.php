@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
        <div class="card mb-4">
            <div class="card-header">Thông tin khách hàng</div>
            <div class="card-body">
                <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Trạng thái:</strong> <span class="badge {{ $order->statusText['class'] }}">{{ $order->statusText['text'] }}</span></p>
            </div>
        </div>

        <h4>Danh sách sản phẩm</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @if ($order->items)
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                             class="img-thumbnail me-2" style="width: 50px; height: 50px;">
                                    @else
                                        <span>Không có ảnh</span>
                                    @endif
                                    <span>{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</span>
                                </div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }} đ</td>
                            <td>{{ number_format($item->price * $item->quantity) }} đ</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Không có sản phẩm trong đơn hàng.</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Tổng tiền:</th>
                    <th>{{ number_format($order->total_amount) }} đ</th>
                </tr>
            </tfoot>
        </table>

        <h4 class="mt-4">Thông tin giao hàng</h4>
        <div class="card mb-4">
            <div class="card-header">Thông tin giao hàng</div>
            <div class="card-body">
                <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có ghi chú' }}</p>
            </div>
        </div>

        <h4 class="mt-4">Thông tin thanh toán</h4>
        <div class="card mb-4">
            <div class="card-header">Phương thức thanh toán</div>
            <div class="card-body">
                <p><strong>Phương thức:</strong> {{ $order->payment_method }}</p>
                <p><strong>Trạng thái thanh toán:</strong>
                    @if ($order->payment_status == 'paid')
                        <span class="badge bg-success">Đã thanh toán</span>
                    @else
                        <span class="badge bg-danger">Chưa thanh toán</span>
                    @endif
                </p>
            </div>
        </div>

        <h4 class="mt-4">Ghi chú</h4>
        <div class="card mb-4">
            <div class="card-header">Ghi chú từ khách hàng</div>
            <div class="card-body">
                <p>{{ $order->notes ?? 'Không có ghi chú' }}</p>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
@endsection
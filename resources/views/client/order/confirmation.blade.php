@extends('layouts.appClient')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="text-success mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> ĐẶT HÀNG THÀNH CÔNG
                        </h4>

                        <div class="text-center mb-4">
                            <i class="bi bi-bag-check-fill display-3 text-warning"></i>
                            <h5 class="mt-3">Cảm ơn bạn đã đặt hàng!</h5>
                            <p>Mã đơn hàng của bạn: <strong>{{ $order->order_code }}</strong></p>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3">Chi tiết đơn hàng</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Tổng cộng</th>
                                        <th>{{ number_format($order->total_amount) }}đ</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <h5 class="border-bottom pb-2 mt-4 mb-3">Thông tin giao hàng</h5>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <strong>Người nhận:</strong> {{ $order->customer_name }}
                            </li>
                            <li class="mb-2">
                                <strong>Địa chỉ:</strong> {{ $order->shipping_address }}
                            </li>
                            <li class="mb-2">
                                <strong>SĐT:</strong> {{ $order->customer_phone }}
                            </li>
                            <li class="mb-2">
                                <strong>Phương thức thanh toán:</strong>
                                {{ $order->payment_method === 'cash' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}
                            </li>
                            <li class="mb-2">
                                <strong>Trạng thái:</strong> {{ $statuses[$order->status]['text'] }}
                            </li>
                        </ul>

                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.index', $order) }}" class="btn btn-outline-primary">
                                <i class="bi bi-receipt me-1"></i> Xem chi tiết đơn hàng
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="bi bi-bag-fill me-1"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add pulse effect to success icon
            const successIcon = document.querySelector('.fa-check-circle');
            successIcon.classList.add('gold-pulse');
        });
    </script>
@endsection

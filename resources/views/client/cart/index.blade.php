@extends('layouts.appClient')

@section('content')
    {{-- add bootstrap5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="container py-5">
        @if ($cartItems->isEmpty())
            <div>
                <div class="empty-cart">
                    <i></i>
                    <h3>GIỎ HÀNG TRỐNG</h3>
                    <p>Chưa có sản phẩm nào trong giỏ hàng của bạn</p>
                    <a href="{{ route('home') }}">
                        <span>
                            <span>TIẾP TỤC MUA SẮM</span>
                            <span></span>
                        </span>
                    </a>
                </div>
            </div>
        @else
            <div class="row">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . ($item->product->image ?? 'default-image.png')) }}"
                                            class="product-img">
                                        <div>
                                            <strong>{{ $item->product->name }}</strong><br>
                                            <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->product->price) }}đ</td>
                                <td>
                                    <form action="{{ route('cart.update', $item) }}" method="POST"
                                        class="d-flex align-items-center">
                                        @csrf @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            max="{{ $item->product->stock }}"
                                            class="form-control form-control-sm w-50 me-2">
                                        <button type="submit" class="btn-icon"><i
                                                class="bi bi-arrow-clockwise"></i></button>
                                    </form>
                                </td>
                                <td>{{ number_format($item->product->price * $item->quantity) }}đ</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-box">
                <h5><i class="bi bi-receipt me-2"></i> Tổng đơn hàng</h5>
                <div class="d-flex justify-content-between mt-3">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($total) }}đ</span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span>Phí vận chuyển:</span>
                    <span>MIỄN PHÍ</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($total) }}đ</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-primary w-100 mt-3">Thanh toán</a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">Tiếp tục mua sắm</a>
            </div>
        @endif
    </div>

    <style>
        <style>
    .empty-cart {
        text-align: center;
        padding: 40px;
        border: 2px dashed #ccc;
        border-radius: 8px;
        color: #777;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 10px;
    }

    .btn-icon {
        background: none;
        border: none;
        color: #007bff;
    }

    .btn-icon:hover {
        color: #0056b3;
    }

    .total-box {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }

    .btn-primary, .btn-outline-secondary {
        border-radius: 6px;
    }
</style>

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effect to cart items
            const cartItems = document.querySelectorAll('tbody tr');
            cartItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(212, 175, 55, 0.05)';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
@endsection

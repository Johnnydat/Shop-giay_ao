@extends('layouts.appClient')

@section('content')
    <div>
        <div class="container py-5">
            <div class="row g-4">
                <!-- Cột thông tin thanh toán -->
                <div class="col-md-7">
                    <div class="checkout-card">
                        <h2 class="checkout-title">THANH TOÁN</h2>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('checkout.place') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <h5>Thông tin cá nhân</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                        value="{{ old('customer_name', Auth::user()->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone"
                                        value="{{ old('customer_phone') }}" required>

                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email"
                                    value="{{ old('customer_email', Auth::user()->email) }}" required>
                            </div>

                            <h5 class="mt-4">Thông tin giao hàng</h5>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Địa chỉ giao hàng</label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="2" required>{{ old('shipping_address') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Địa chỉ thanh toán (nếu khác)</label>
                                <textarea class="form-control" id="billing_address" name="billing_address" rows="2">{{ old('billing_address') }}</textarea>
                            </div>

                            <h5 class="mt-4">Phương thức thanh toán</h5>
                            <!-- Form thanh toán -->
                            <input class="form-check-input" type="radio" name="payment_method" value="cash"
                                id="cod" checked>
                            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>

                            <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer"
                                id="bank">
                            <label class="form-check-label" for="bank">Chuyển khoản ngân hàng</label>


                            <div class="mb-3">
                                <label for="notes" class="form-label">Ghi chú đơn hàng</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Yêu cầu đặc biệt...">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-checkout">ĐẶT HÀNG</button>
                        </form>
                    </div>
                </div>

                <!-- Cột tóm tắt đơn hàng -->
                <div class="col-md-5">
                    <div class="order-summary">
                        <h4 class="mb-3">TÓM TẮT ĐƠN HÀNG</h4>
                        @foreach ($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2 order-item">
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('storage/default-image.png') }}">
                                    <div class="ms-2">
                                        <div>{{ $item->product->name }}</div>
                                        <small class="text-muted">x{{ $item->quantity }}</small>
                                    </div>
                                </div>
                                <div>{{ number_format($item->product->price * $item->quantity) }}đ</div>
                            </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính</span>
                            <span>{{ number_format($total) }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển</span>
                            <span>MIỄN PHÍ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Thuế</span>
                            <span>0đ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Tổng cộng</span>
                            <span>{{ number_format($total) }}đ</span>
                        </div>

                        <div class="text-center mt-4">
                            <i class="fas fa-lock text-muted me-2"></i>
                            <small class="text-muted">Thanh toán an toàn (SSL 256-bit)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <style>
        .checkout-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .checkout-title {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .order-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .order-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        .form-check label {
            font-weight: 500;
        }

        .btn-checkout {
            width: 100%;
            padding: 12px;
            font-weight: bold;
        }
    </style>


    <!-- Include Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Include Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add gold pulse effect to payment method when selected
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.checked) {
                        const label = this.closest('.form-check').querySelector(
                            '.form-check-label');
                        label.classList.add('gold-pulse');

                        // Remove pulse from other labels
                        paymentMethods.forEach(m => {
                            if (m !== this) {
                                m.closest('.form-check').querySelector('.form-check-label')
                                    .classList.remove('gold-pulse');
                            }
                        });
                    }
                });
            });

            // Initialize first payment method as active
            if (paymentMethods.length > 0) {
                paymentMethods[0].dispatchEvent(new Event('change'));
            }
        });
        
    </script>
@endsection

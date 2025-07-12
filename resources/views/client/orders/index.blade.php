@extends('layouts.appClient')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="container py-5">
        <h1 class="text-center mb-5 text-gold" style="font-family: 'Playfair Display', serif;">
            <i class="fas fa-receipt me-2"></i> DANH SÁCH ĐƠN HÀNG
        </h1>

        @if (session('success'))
            <div class="alert alert-gold mb-4"
                style="background: rgba(212,175,55,0.2); border-left: 4px solid #d4af37; color: #d4af37;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger mb-4"
                style="background: rgba(220,53,69,0.2); border-left: 4px solid #dc3545; color: #dc3545;">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row g-4">
            @foreach ($orders as $order)
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Mã đơn hàng #{{ $order->id }}</h5>
                                <span
                                    class="badge 
                            @if ($order->status == 'pending' || $order->status == 'processing') bg-warning text-dark 
                            @elseif($order->status == 'shipped') bg-info 
                            @elseif($order->status == 'delivered') bg-success 
                            @elseif($order->status == 'cancelled') bg-secondary @endif">
                                    @switch($order->status)
                                        @case('pending')
                                            Đang xử lý
                                        @break

                                        @case('processing')
                                            Đang xử lý
                                        @break

                                        @case('shipped')
                                            Đang vận chuyển
                                        @break

                                        @case('delivered')
                                            Đã giao hàng
                                        @break

                                        @case('cancelled')
                                            Đã hủy
                                        @break
                                    @endswitch
                                </span>
                            </div>

                            <ul class="list-unstyled mb-3">
                                <li><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</li>
                                <li><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND
                                </li>
                            </ul>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                    Xem chi tiết
                                </a>

                                @if ($order->status == 'shipped')
                                    <form action="{{ route('orders.confirm', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Xác nhận đã nhận
                                        </button>
                                    </form>
                                @elseif($order->status == 'pending')
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hủy đơn hàng
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        {{-- <div class="d-flex justify-content-center mt-5">
        {{ $orders->links('vendor.pagination.custom') }}
    </div> --}}
    </div>

    
@endsection

@extends('layouts.appClient')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">



@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">
        <i class="fas fa-file-invoice me-2"></i>Chi tiết đơn hàng #{{ $order->id }}
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <strong>Thông tin đơn hàng</strong>
        </div>
        <div class="card-body">
            <p><strong>Trạng thái:</strong>
                @switch($order->status)
                    @case('pending') <span class="badge bg-warning text-dark">Đang xử lý</span> @break
                    @case('processing') <span class="badge bg-warning text-dark">Đang xử lý</span> @break
                    @case('shipped') <span class="badge bg-info">Đang vận chuyển</span> @break
                    @case('delivered') <span class="badge bg-success">Đã giao hàng</span> @break
                    @case('cancelled') <span class="badge bg-secondary">Đã hủy</span> @break
                @endswitch
            </p>
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Sản phẩm trong đơn hàng</strong>
        </div>
        <div class="card-body">
            @foreach($order->items as $item)
                <div class="d-flex align-items-center border-bottom py-2">
                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('storage/default-image.png') }}"
                         class="rounded me-3" alt="product" width="80" height="80">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                        <div class="text-muted small">
                            Số lượng: {{ $item->quantity }} | 
                            Giá: {{ number_format($item->product->price, 0, ',', '.') }} VND
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex gap-2">
        @if($order->status == 'shipped')
            <form action="{{ route('orders.confirm', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle me-1"></i> Xác nhận đã nhận hàng
                </button>
            </form>
        @elseif($order->status == 'pending')
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times-circle me-1"></i> Hủy đơn hàng
                </button>
            </form>
        @endif

        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>
</div>
@endsection





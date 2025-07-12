@extends('layouts.appClient')
@section('title', $title)

@section('content')
    <link href="{{ asset('css/styleShop.css') }}" rel="stylesheet">

    <div class="container py-5">
        <!-- Tiêu đề và Sort -->
        <div class="row mb-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0" style="font-family: 'Playfair Display', serif;">
                    Trang sản phẩm
                </h2>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted">Sắp xếp:</span>
                    <button class="btn btn-outline-secondary btn-sm">
                        Mới nhất <i class="bi bi-chevron-down ms-1"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Bộ lọc -->
            @include('client.partials.filters')

            <!-- Danh sách sản phẩm -->
            <div class="col-lg-9">
                @if ($products->isEmpty())
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-search me-2"></i> Không tìm thấy sản phẩm nào phù hợp với bộ lọc hiện tại.
                    </div>
                @else
                    <div class="row g-4">
                        @foreach ($products as $item)
                            <div class="col-md-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="position-relative">
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('storage/default-image.png') }}"
                                             alt="{{ $item->name }}"
                                             class="card-img-top"
                                             style="height: 220px; object-fit: cover;">
                                        @if ($item->discount)
                                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                                -{{ $item->discount }}%
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <span class="badge bg-light text-dark mb-2">
                                            {{ $item->category->name ?? 'Không phân loại' }}
                                        </span>
                                        <h6 class="fw-bold text-truncate">
                                            <a href="{{ route('products.show', $item->id) }}" class="text-decoration-none text-dark">
                                                {{ $item->name }}
                                            </a>
                                        </h6>
                                        <div class="mt-2">
                                            @if ($item->discount)
                                                <span class="fw-bold text-danger">
                                                    ${{ number_format($item->price - ($item->price * $item->discount) / 100, 2) }}
                                                </span>
                                                <span class="text-muted text-decoration-line-through ms-2">
                                                    ${{ number_format($item->price, 2) }}
                                                </span>
                                            @else
                                                <span class="fw-bold">${{ number_format($item->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Phân trang -->
                    <div class="mt-4">
                        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

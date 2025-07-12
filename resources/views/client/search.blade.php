@extends('client.layouts.app')
@section('title', $title)

@section('content')
    <link href="{{ asset('css/styleShop.css') }}" rel="stylesheet">

    <div class="container py-5">
        <div class="row g-4">
            <!-- Phần header tìm kiếm -->
            <div class="col-12">
                <div class="search-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0" style="font-family: 'Playfair Display', serif;">
                        Tìm kiếm sản phẩm:"<span class="text-gold">{{ $searchTerm }}</span>"
                    </h4>
                    <div class="d-flex gap-2 align-items-center">
                        <span class="text-muted">Sort by:</span>
                        <button class="sort-btn">
                            Newest <i class="bi bi-chevron-down ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form lọc sản phẩm -->
            @include('client.layouts.partials.filtersSearch')

            <!-- Danh sách sản phẩm -->
            <div class="col-lg-9">
                @if ($products->isEmpty())
                    <div class="alert alert-info text-center py-4">
                        <i class="bi bi-search me-2"></i> Không tìm thấy sản phẩm nào phù hợp với từ khóa
                        "{{ $searchTerm }}" và bộ lọc hiện tại.
                    </div>
                @else
                    <div class="row g-4">
                        @foreach ($products as $item)
                            <div class="col-md-4">
                                <div class="product-card h-100">
                                    <div class="product-img-container position-relative">
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('storage/default-image.png') }}"
                                            class="product-img" alt="{{ $item->name }}">
                                        @if ($item->discount)
                                            <span
                                                class="badge discount-badge position-absolute top-0 end-0 m-2">-{{ $item->discount }}%</span>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <span class="category-badge badge rounded-pill px-2 mb-2">
                                            {{ $item->category->name ?? 'Không phân loại' }}
                                        </span>
                                        <a class="product-name" href="{{ route('products.show', $item->id) }}">
                                            <h6 class="mb-1 fw-bold">{{ $item->name }}</h6>
                                        </a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($item->discount)
                                                <div>
                                                    <span class="fw-bold text-danger">
                                                        ${{ number_format($item->price - ($item->price * $item->discount) / 100, 2) }}
                                                    </span>
                                                    <span class="text-muted text-decoration-line-through ms-2">
                                                        ${{ number_format($item->price, 2) }}
                                                    </span>
                                                </div>
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
                    {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('layouts.appClient')

@section('content')
    <!-- Hero Slider -->
    <div class="slider">
        @include('client.partials.slide')
    </div>

    <!-- Feature Section -->
    <div class="feature-boxes">
        @include('client.partials.feature-box')
    </div>

    <!-- Product Slider Section -->
    <section class="container py-5">
        <div class="position-relative">
            <button class="flickity-button prev"></button>
            <div class="product-slider d-flex overflow-auto gap-3 pb-3">
                @foreach ($products as $product)
                    <div class="card border-0 shadow-sm rounded overflow-hidden" style="min-width: 280px;">
                        <div class="position-relative">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/default-image.png') }}" class="w-100" style="height: 200px; object-fit: cover;">
                            <span class="badge position-absolute top-0 end-0 m-2 bg-gold text-white">NEW</span>
                        </div>
                        <div class="card-body">
                            <h5 class="fw-semibold text-dark mb-2">
                                <a href="{{ route('products.show', $product->id) }}" 
                                    class="text-decoration-none text-dark">{{ $product->name }}</a>
                            </h5>
                            <p class="text-muted small">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-gold fw-bold">${{ $product->price }}</span>
                                <button class="btn btn-outline-gold btn-sm"><i class="bi bi-heart"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="flickity-button next"></button>
        </div>
    </section>

    <!-- Most Viewed Products -->
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="text-center mb-4 text-gold fw-bold">Sản phẩm được xem nhiều</h3>
            <div class="luxury-slider position-relative">
                <div class="slider-track d-flex overflow-auto gap-4 pb-3">
                    @foreach ($mostViewedProducts as $product)
                        <div class="card border rounded shadow-sm" style="min-width: 280px;">
                            <div class="position-relative">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/default-image.png') }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                                @if ($product->created_at->diffInDays() < 7)
                                    <span class="badge bg-gold text-white position-absolute top-0 end-0 m-2">NEW</span>
                                @endif
                                <span class="position-absolute bottom-0 start-0 m-2 badge bg-dark text-gold"><i class="bi bi-eye-fill"></i> {{ $product->views }} lượt xem</span>
                            </div>
                            <div class="card-body">
                                <h5><a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">{{ $product->name }}</a></h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-gold fw-bold">{{ number_format($product->price) }}₫</span>
                                    <div class="text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Pagination -->
    <div class="container my-5">
        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
    </div> --}}
@endsection

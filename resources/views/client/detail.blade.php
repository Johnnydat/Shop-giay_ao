@extends('layouts.appClient')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styleDetail.css') }}">
    @error('content')
        <div class="text-danger mt-2">{{ $message }}</div>
    @enderror
    <!-- Phần sản phẩm chính -->
    <div class="container py-5">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    @if (isset($product->image))
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/default-image.png') }}"
                            class="card-img-top" alt="Product Image">
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                @if (isset($product->name))
                    <h1 class="h2 mb-3">{{ $product->name }}</h1>
                @endif

                <div class="mb-3">
                    @if (isset($product->price))
                        <span class="h4 me-2">${{ number_format($product->price, 2) }}</span>
                        <span class="badge bg-danger ms-2">25% OFF</span>
                    @endif
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <div class="text-warning me-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        @if (isset($product->views))
                            <span class="text-muted">({{ $product->views }} reviews)</span>
                        @endif
                    </div>
                </div>

                @if (isset($product->description))
                    <p class="mb-4">{{ $product->description }}</p>
                @endif

                <!-- Color Selection -->
                <div class="mb-4">
                    <h6 class="mb-2">Color</h6>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="color" id="silver" checked>
                        <label class="btn btn-outline-secondary" for="silver">Silver</label>
                        <input type="radio" class="btn-check" name="color" id="gold">
                        <label class="btn btn-outline-secondary" for="gold">Gold</label>
                        <input type="radio" class="btn-check" name="color" id="black">
                        <label class="btn btn-outline-secondary" for="black">Black</label>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <div class="d-flex align-items-center">
                        <label class="me-2">Quantity:</label>
                        <select class="form-select w-auto" name="quantity" form="addToCartForm">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-grid gap-2">
                    <!-- Form thêm vào giỏ hàng -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </form>

                    <button class="btn btn-outline-secondary" type="button">
                        <i class="far fa-heart me-2"></i>Add to Wishlist
                    </button>
                </div>

                <!-- Additional Info -->
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-truck text-primary me-2"></i>
                        <span>Free shipping on orders over $50</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-undo text-primary me-2"></i>
                        <span>30-day return policy</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-alt text-primary me-2"></i>
                        <span>2-year warranty</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần bình luận -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">Bình luận sản phẩm</h3>

                <!-- Form bình luận -->
                @auth
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('products.comments.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-warning mt-2">Gửi bình luận</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}" class="text-primary">Đăng nhập</a> để bình luận về sản phẩm này.
                    </div>
                @endauth

                <!-- Danh sách bình luận -->
                <div class="comments-section">
                    @foreach ($comments as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    {{-- <div>
                                        {{ $comment->content }}
                                    </div> --}}


                                    <div class="flex-shrink-0">
                                        @if ($comment->user && $comment->user->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                alt="{{ $comment->user->username }}" class="rounded-circle"
                                                width="50" style="object-fit: cover; height: 50px;">
                                        @else
                                            @php
                                                $username = $comment->user ? $comment->user->username : 'Khách';
                                            @endphp
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($username) }}&background=random"
                                                alt="{{ $username }}" class="rounded-circle" width="50"
                                                style="object-fit: cover; height: 50px;">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ $comment->user->full_name ?? 'Người dùng đã xóa' }}</h6>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mt-2 mb-2">{{ $comment->content }}</p>

                                        <!-- Nút trả lời -->
                                        @auth
                                            <button class="btn btn-sm btn-outline-secondary reply-btn"
                                                data-comment-id="{{ $comment->id }}">
                                                <i class="fas fa-reply"></i> Trả lời
                                            </button>
                                        @endauth

                                        <!-- Form trả lời (ẩn) -->
                                        @auth
                                            <div class="reply-form mt-3" id="reply-form-{{ $comment->id }}"
                                                style="display: none;">
                                                <form action="{{ route('products.comments.store', $product->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <div class="form-group">
                                                        <textarea name="content" class="form-control" rows="2" placeholder="Viết trả lời của bạn..." required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-warning mt-2">Gửi trả
                                                        lời</button>
                                                </form>
                                            </div>
                                        @endauth




                                        <!-- Hiển thị các câu trả lời -->
                                        @foreach ($comment->replies as $reply)
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            @if ($reply->user && $reply->user->avatar)
                                                                <img src="{{ asset('storage/' . $reply->user->avatar) }}"
                                                                    alt="{{ $reply->user->username }}"
                                                                    class="rounded-circle" width="40"
                                                                    style="object-fit: cover; height: 40px;">
                                                            @else
                                                                @php
                                                                    $replyName = $reply->user
                                                                        ? $reply->user->username
                                                                        : 'Khách';
                                                                @endphp
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($replyName) }}&background=random"
                                                                    alt="{{ $replyName }}" class="rounded-circle"
                                                                    width="40"
                                                                    style="object-fit: cover; height: 40px;">
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0">
                                                                    {{ $reply->user->full_name ?? 'Người dùng đã xóa' }}
                                                                </h6>
                                                                <small
                                                                    class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                            </div>
                                                            <p class="mt-2 mb-0">{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($comments->isEmpty())
                        <div class="alert alert-info">
                            Chưa có bình luận nào. Hãy là người đầu tiên bình luận về sản phẩm này!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Phần sản phẩm cùng loại - Full width -->
    <section class="bg-light py-5">
        <div class="container-fluid px-0">
            <h2 class="text-center mb-5 display-5 fw-light">SẢN PHẨM TƯƠNG TỰ</h2>

            <div class="row g-0">
                @foreach ($relatedProducts->take(5) as $product)
                    <div class="col" style="flex: 0 0 20%; max-width: 20%;">
                        <div class="card h-100 border-0 rounded-0 shadow-sm mx-2">
                            <span
                                class="position-absolute top-0 end-0 m-2 bg-warning text-white px-2 py-1 small rounded-pill">-25%</span>

                            <div class="ratio ratio-1x1 position-relative overflow-hidden">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/default-image.png') }}"
                                    class="card-img-top object-fit-cover" alt="{{ $product->name }}">
                                <div class="position-absolute bottom-0 start-0 end-0 text-center p-2"
                                    style="transform: translateY(100%); transition: all 0.3s ease;">
                                    <button class="btn btn-dark btn-sm rounded-pill px-3">XEM NHANH</button>
                                </div>
                            </div>

                            <div class="card-body">
                                <small
                                    class="text-muted text-uppercase">{{ $product->category->name ?? 'Luxury' }}</small>
                                <a class="product-name" href="{{ route('products.show', $product->id) }}">
                                    <h5 class="card-title fs-6 mt-1 mb-2 text-truncate">{{ $product->name }}</h5>
                                </a>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <small class="text-muted">(4.5)</small>
                                </div>

                                <div>
                                    <span
                                        class="fw-bold text-warning">${{ number_format($product->price * 0.75, 2) }}</span>
                                    <span
                                        class="text-decoration-line-through text-muted ms-2">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-0 pt-0">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                        class="d-inline-flex flex-grow-1 me-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-outline-warning btn-sm rounded-pill w-100">
                                            <i class="bi bi-cart-plus"></i> Thêm
                                        </button>
                                    </form>
                                    <button class="btn btn-outline-secondary btn-sm rounded-circle">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Thêm JavaScript để xử lý nút trả lời -->
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý nút trả lời
            document.querySelectorAll('.reply-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const replyForm = document.getElementById(`reply-form-${commentId}`);

                    if (replyForm.style.display === 'none') {
                        replyForm.style.display = 'block';
                        this.innerHTML = '<i class="fas fa-times"></i> Hủy';
                    } else {
                        replyForm.style.display = 'none';
                        this.innerHTML = '<i class="fas fa-reply"></i> Trả lời';
                    }
                });
            });

            // Hiển thị thông báo
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        });
    </script>
@endsection
@endsection

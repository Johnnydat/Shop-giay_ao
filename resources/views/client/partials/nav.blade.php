<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">ShopNow</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href=" {{ route('home') }}">Trang Chủ</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop') }}">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.index') }}">Tin tức</a>
                </li>
                
            </ul>
            <!-- Search Bar -->
            <form class="d-flex search-bar mx-auto" role="search">
                <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </form>

            <ul class="navbar-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> Tài Khoản
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                        @auth
                            @if (auth()->check() && auth()->user()->role == 'admin')
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashBoard') }}">Trang quản trị</a></li>
                            @else
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            @endif
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Đăng Nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Đăng Ký</a></li>
                        @endauth
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link cart-icon" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

 <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt"></i>
                Admin Panel
            </a>

            <!-- Mobile Toggle -->
            <button class="btn btn-outline-light sidebar-toggle d-lg-none" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar Items -->
            <div class="navbar-nav ms-auto">
                
                <!-- User Menu -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://images2.minutemediacdn.com/image/upload/c_crop,w_1199,h_674,x_0,y_0/c_fill,w_1200,ar_1:1,f_auto,q_auto,g_auto/images/voltaxMediaLibrary/mmsport/wrestling_on_fannation/01jckmhdsjqj6w5148bq.jpg" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                        <span>Admin User</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        
                        @auth
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('home') }}">Trang người dùng</a></li>
                        @endauth
                        
                    </ul>
                </div>
            </div>
        </div>
    </nav>
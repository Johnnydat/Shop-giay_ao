<div class="admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5><i class="fas fa-tachometer-alt me-2"></i>Bảng điều khiển</h5>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-item">
                <a href="{{ route('admin.dashBoard') }}" class="menu-link active">
                    <i class="fas fa-home"></i>
                    <span>Trang chủ</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.categories.index') }}" class="menu-link">
                    <i class="fas fa-users"></i>
                    <span>Quản lý danh mục</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.products.index') }}" class="menu-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Quản lý sản phẩm</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.slides.index') }}" class="menu-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Quản lý slide</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.news.index') }}" class="menu-link">
                    <i class="fas fa-file-alt"></i>
                    <span>Quản lý  bài viết</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.users.index') }}" class="menu-link">
                    <i class="fas fa-cog"></i>
                    <span>Quản lý tài khoản</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.comments.index') }}" class="menu-link">
                    <i class="fas fa-comments"></i>
                    <span>Quản lý bình luận</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.orders.index') }}" class="menu-link">
                    <i class="fas fa-receipt"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
            </div>

        </div>
    </div>
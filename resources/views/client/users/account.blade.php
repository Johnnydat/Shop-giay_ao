@extends('client.layouts.app')
@section('title', 'Tài khoản của tôi')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
        }

        body {
            background-color: #f8f9fa;
        }

        .account-container {
            max-width: 1200px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .account-sidebar {
            background-color: var(--secondary-color);
            color: white;
            padding: 30px 0;
            height: 100%;
        }

        .account-sidebar .nav-link {
            color: var(--light-color);
            padding: 12px 25px;
            border-radius: 0;
            transition: all 0.3s;
        }

        .account-sidebar .nav-link:hover,
        .account-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 3px solid var(--primary-color);
        }

        .account-sidebar .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        .account-content {
            padding: 30px;
        }

        .avatar-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .avatar-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .avatar-upload {
            position: relative;
            display: inline-block;
            margin-top: 10px;
        }

        .avatar-upload-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .avatar-upload-btn:hover {
            background-color: #2980b9;
        }

        .avatar-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .form-section h4 {
            color: var(--secondary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }

        .btn-save {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-save:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>

    <div class="account-container">
        <div class="row g-0">
            <div class="col-md-3">
                <div class="account-sidebar">
                    <div class="avatar-container">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/default-image.png') }}"
                            class="avatar-img" id="avatar-preview">
                        <div class="avatar-upload mt-3">
                            <button class="avatar-upload-btn">
                                <i class="fas fa-camera me-2"></i>Thay đổi
                            </button>
                            <form id="avatar-form" action="{{ route('user.update-avatar') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="avatar" id="avatar-input" accept="image/*">
                            </form>
                        </div>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#profile-info" data-bs-toggle="tab">
                                <i class="fas fa-user"></i> Thông tin cá nhân
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#change-password" data-bs-toggle="tab">
                                <i class="fas fa-lock"></i> Đổi mật khẩu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#orders" data-bs-toggle="tab">
                                <i class="fas fa-shopping-bag"></i> Đơn hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#addresses" data-bs-toggle="tab">
                                <i class="fas fa-map-marker-alt"></i> Địa chỉ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="account-content">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="tab-content">
                        <!-- Tab Thông tin cá nhân -->
                        <div class="tab-pane fade show active" id="profile-info">
                            <div class="form-section">
                                <h4><i class="fas fa-user-circle me-2"></i>Thông tin cá nhân</h4>
                                <form action="{{ route('user.update-info') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="full_name" class="form-label">Họ và tên</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name"
                                                value="{{ old('full_name', $user->full_name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">Tên đăng nhập</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ old('username', $user->username) }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Số điện thoại</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Giới tính</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="male" value="M"
                                                        {{ old('gender', $user->gender) == 'M' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="male">Nam</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="female" value="F"
                                                        {{ old('gender', $user->gender) == 'F' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="female">Nữ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="other" value="O"
                                                        {{ old('gender', $user->gender) == 'O' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="other">Khác</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="shipping_address" class="form-label">Địa chỉ giao hàng</label>
                                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3">{{ old('shipping_address', $user->shipping_address) }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-save">
                                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Tab Đổi mật khẩu -->
                        <div class="tab-pane fade" id="change-password">
                            <div class="form-section">
                                <h4><i class="fas fa-lock me-2"></i>Đổi mật khẩu</h4>
                                <form action="{{ route('user.change-password') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                        <small class="text-muted">Mật khẩu phải có ít nhất 8 ký tự</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu
                                            mới</label>
                                        <input type="password" class="form-control" id="new_password_confirmation"
                                            name="new_password_confirmation" required>
                                    </div>

                                    <button type="submit" class="btn btn-save">
                                        <i class="fas fa-key me-2"></i>Đổi mật khẩu
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Tab Đơn hàng -->
                        <div class="tab-pane fade" id="orders">
                            <div class="form-section">
                                <h4><i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($orders->isEmpty())
                                                <tr>
                                                    <td colspan="5" class="text-center">Bạn chưa có đơn hàng nào.</td>
                                                </tr>
                                            @else
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>{{ number_format($order->total_amount) }}đ</td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'shipped' ? 'bg-success' : 'bg-secondary') }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('orders.show', $order->id) }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-eye"></i> Xem
                                                            </a>
                                                            @if ($order->status == 'pending')
                                                                <form action="{{ route('orders.cancel', $order->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm ms-2">
                                                                        <i class="fas fa-times"></i> Hủy
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Địa chỉ -->
                        <div class="tab-pane fade" id="addresses">
                            <div class="form-section">
                                <h4><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ của tôi</h4>
                                <div class="row">
                                    <!-- Danh sách địa chỉ sẽ được thêm ở đây -->
                                    <div class="col-12 text-center py-5">
                                        <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Bạn chưa có địa chỉ nào</p>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Thêm địa chỉ mới
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Xử lý upload avatar
        document.getElementById('avatar-input').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }

                reader.readAsDataURL(this.files[0]);
                document.getElementById('avatar-form').submit();
            }
        });

        // Hiển thị tab active khi có hash trong URL
        window.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash) {
                const tabTrigger = new bootstrap.Tab(document.querySelector(`a[href="${window.location.hash}"]`));
                tabTrigger.show();
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validation/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validation/1.19.3/additional-methods.min.js"></script>
@endsection

Tạo trang xem chi tiết người dùng
@extends('layouts.app')
@section('title', 'Chi tiết người dùng')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Chi tiết người dùng</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID:</strong> {{ $user->id }}</p>
                                <p><strong>Tên:</strong> {{ $user->username }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
                                <p><strong>Địa chỉ:</strong> {{ $user->address }}</p>
                                <p><strong>Giới tính:</strong> {{ $user->gender ? 'Nam' : 'Nữ' }}</p>
                                <p><strong>Vai trò:</strong> {{ $user->role }}</p>
                                <p><strong>Trạng thái:</strong> {{ $user->status ? 'Kích hoạt' : 'Không kích hoạt' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Ngày cập nhật:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                Quay lại
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <style>
        /* Card & Container */
        .card {
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(52, 152, 219, 0.07);
            border: none;
            margin-top: 32px;
            background: #fff;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, #3498db 0%, #6dd5fa 100%);
            color: #fff;
            border-bottom: none;
            padding: 18px 24px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .card-body {
            padding: 28px 32px 18px 32px;
        }

        .row>.col-md-6 {
            padding-bottom: 12px;
        }

        .card-body p {
            font-size: 1.05rem;
            margin-bottom: 10px;
            color: #333;
        }

        .card-body strong {
            min-width: 110px;
            display: inline-block;
            color: #2980b9;
        }

        .badge-status {
            padding: 5px 14px;
            border-radius: 16px;
            font-size: 0.95rem;
            font-weight: 600;
            margin-left: 6px;
        }

        .badge-active {
            background: #27ae60;
            color: #fff;
        }

        .badge-inactive {
            background: #95a5a6;
            color: #fff;
        }

        .btn-secondary {
            border-radius: 6px;
            font-weight: 500;
            background: #95a5a6;
            color: #fff;
            border: none;
            transition: background 0.18s;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            color: #fff;
        }

        .mt-3 {
            margin-top: 1.5rem !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-body {
                padding: 14px 8px 10px 8px;
            }

            .card-title {
                font-size: 1rem;
            }

            .row>.col-md-6 {
                padding-bottom: 6px;
            }

            .card-body p {
                font-size: 0.97rem;
            }
        }
    </style>
@endsection

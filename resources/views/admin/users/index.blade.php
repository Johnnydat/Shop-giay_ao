Tạo trang quản lý người dùng
@extends('layouts.app')
@section('title', 'Quản lý người dùng')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Danh sách người dùng</h3>
                        <div class="card-tools">
                            <form method="GET" action="{{ route('admin.users.index') }}">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Tìm theo tên hoặc email" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->status === 'active' ? 'Kích hoạt' : 'Không kích hoạt' }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="btn btn-info btn-sm">
                                                Xem
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.lock', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $user->status == 'banned' ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                                        title="{{ $user->status == 'banned' ? 'Bỏ chặn' : 'Chặn tài khoản' }}">
                                                        <i
                                                            class="fas {{ $user->status == 'banned' ? 'fa-unlock' : 'fa-ban' }}"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $users->links('pagination::bootstrap-5') }}
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
            margin-top: 24px;
            background: #fff;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, #3498db 0%, #6dd5fa 100%);
            color: #fff;
            border-bottom: none;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .card-tools .input-group {
            min-width: 260px;
        }

        .card-body {
            padding: 0;
        }

        /* Table Styling */
        .table {
            margin-bottom: 0;
            background: transparent;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
            border: none;
        }

        .table thead th {
            background: #3498db;
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: none;
            padding: 14px 10px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: #f8fafc;
        }

        .table-striped tbody tr:nth-of-type(even) {
            background: #eaf6fb;
        }

        .table tbody tr {
            transition: background 0.2s;
        }

        .table tbody tr:hover {
            background: #d0ecfa !important;
        }

        .table td {
            font-size: 0.97rem;
            color: #333;
            padding: 12px 10px;
        }

        /* Badge Styling */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.92rem;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .bg-success {
            background: #27ae60 !important;
            color: #fff !important;
        }

        .bg-secondary {
            background: #95a5a6 !important;
            color: #fff !important;
        }

        /* Button Styling */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.18s;
            box-shadow: none;
            border: none;
        }

        .btn-info {
            background: #2980b9;
            color: #fff;
        }

        .btn-info:hover {
            background: #1c5d8c;
            color: #fff;
        }

        .btn-outline-danger {
            color: #e74c3c;
            border: 1px solid #e74c3c;
            background: transparent;
        }

        .btn-outline-danger:hover,
        .btn-outline-danger:focus {
            background: #e74c3c;
            color: #fff;
        }

        .btn-outline-success {
            color: #27ae60;
            border: 1px solid #27ae60;
            background: transparent;
        }

        .btn-outline-success:hover,
        .btn-outline-success:focus {
            background: #27ae60;
            color: #fff;
        }

        .btn:active {
            transform: scale(0.97);
        }

        /* Pagination Styling */
        .pagination {
            margin-top: 18px;
            justify-content: flex-end;
        }

        .page-link {
            border-radius: 6px !important;
            margin: 0 2px;
            color: #2980b9;
            border: none;
        }

        .page-item.active .page-link {
            background: #3498db;
            color: #fff;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.13);
            border: none;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .card-header,
            .card-body {
                padding: 12px 6px;
            }

            .table th,
            .table td {
                padding: 8px 4px;
                font-size: 0.93rem;
            }

            .card-title {
                font-size: 1rem;
            }
        }
    </style>
@endsection

Tạo trang quản lý đơn hàng
@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Quản lý đơn hàng</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ number_format($order->total, 2) }} VNĐ</td>
                        <td>
                            @if ($order->status === 'completed')
                                <span class="badge badge-success">Hoàn thành</span>
                            @elseif($order->status === 'pending')
                                <span class="badge badge-warning">Chờ xử lý</span>
                            @elseif($order->status === 'cancelled')
                                <span class="badge badge-danger">Đã hủy</span>
                            @else
                                <span class="badge badge-info">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">Xem</a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                class="delete-form d-inline" data-id="{{ $order->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn action-btn delete-btn" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
@endsection
@section('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    delay: {
                        show: 300,
                        hide: 100
                    }
                });
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const postId = form.getAttribute('data-id');

                Swal.fire({
                    title: 'Cảnh báo!',
                    html: `Bạn có chắc chắn muốn <strong>xóa bài viết</strong>"`,
                    icon: 'warning',
                    iconColor: '#dc3545',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Xóa ngay',
                    cancelButtonText: '<i class="fas fa-times me-1"></i> Hủy',
                    reverseButtons: true,
                    width: '400px',
                    customClass: {
                        popup: 'category-trash-alert'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <style>
        /* Table container */
        .container {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(52, 152, 219, 0.07);
            padding: 32px 24px 24px 24px;
            margin-top: 32px;
        }

        /* Table styling */
        .table {
            background: transparent;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0;
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

        .table tbody tr {
            background: #f8fafc;
            transition: background 0.2s;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody tr:hover {
            background: #eaf6fb;
        }

        .table td {
            font-size: 0.97rem;
            color: #333;
            padding: 12px 10px;
        }

        /* Badge for status */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.92rem;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .badge-success {
            background: #27ae60;
            color: #fff;
        }

        .badge-warning {
            background: #f39c12;
            color: #fff;
        }

        .badge-danger {
            background: #e74c3c;
            color: #fff;
        }

        .badge-info {
            background: #2980b9;
            color: #fff;
        }

        /* Action buttons */
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

        .action-btn.delete-btn {
            background: #e74c3c;
            color: #fff;
            margin-left: 4px;
        }

        .action-btn.delete-btn:hover {
            background: #c0392b;
            color: #fff;
        }

        .btn:active {
            transform: scale(0.97);
        }

        /* Pagination styling */
        .pagination {
            margin-top: 24px;
            justify-content: center;
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
            .container {
                padding: 12px 4px;
            }

            .table th,
            .table td {
                padding: 8px 4px;
                font-size: 0.93rem;
            }
        }
    </style>
@endsection

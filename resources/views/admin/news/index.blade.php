@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="my-4">Quản lý bài viết</h1>
        <div class="mb-3">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Thêm tin tức mới</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tiêu đề</th>
                    <th>Slug</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $item)
                    <tr>
                        <td>{{ ($news->currentPage() - 1) * $news->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->slug }}</td>

                        <td class="text-center">
                            @if ($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Ảnh bài viết"
                                    class="img-thumbnail rounded shadow-sm"
                                    style="width:80px; height:60px; object-fit:cover;">
                            @else
                                <span class="badge bg-light text-secondary">Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $item->is_published ? 'Hiển thị' : 'Ẩn' }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST"
                                class="delete-form d-inline" data-id="{{ $item->id }}">
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
        {{ $news->links('pagination::bootstrap-5') }}
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
        .container {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(52, 152, 219, 0.07);
            padding: 32px 24px 24px 24px;
            margin-top: 32px;
        }

        h1.my-4 {
            font-weight: 700;
            color: #3498db;
            letter-spacing: 1px;
        }

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

        .img-thumbnail {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(52, 152, 219, 0.10);
            transition: transform 0.2s;
        }

        .img-thumbnail:hover {
            transform: scale(1.07);
        }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.92rem;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .bg-light.text-secondary {
            background: #f4f6f8 !important;
            color: #7b8a8b !important;
            border: 1px solid #e1e4e8;
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.18s;
            box-shadow: none;
            border: none;
        }

        .btn-primary {
            background: #3498db;
            color: #fff;
        }

        .btn-primary:hover {
            background: #217dbb;
            color: #fff;
        }

        .btn-warning {
            background: #f39c12;
            color: #fff;
        }

        .btn-warning:hover {
            background: #d68910;
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

            h1.my-4 {
                font-size: 1.2rem;
            }
        }
    </style>
@endsection

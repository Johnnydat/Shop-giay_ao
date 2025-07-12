@extends('layouts.app')

@section('tieude')
    {{ $tieude }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $tieude }}</h2>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên danh mục</th>
                            <th>Ảnh</th>
                            <th>Trạng thái</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>

                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="Ảnh danh mục"
                                            class="img-thumbnail rounded shadow-sm"
                                            style="width:80px; height:60px; object-fit:cover;">
                                    @else
                                        <span class="badge bg-light text-secondary">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $category->status ? 'success' : 'secondary' }}">
                                        {{ $category->status ? 'Hoạt động' : 'khóa' }}
                                    </span>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        class="delete-form d-inline" data-id="{{ $category->id }}">
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

                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
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
                    html: `Bạn có chắc chắn muốn <strong>xóa danh mục</strong>"`,
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
        /* Container & Card */
        .container {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(52, 152, 219, 0.07);
            padding: 32px 24px 24px 24px;
            margin-top: 32px;
        }

        h2 {
            font-weight: 700;
            color: #3498db;
            letter-spacing: 1px;
            margin-bottom: 18px;
        }

        /* Table Styling */
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

        .bg-light.text-secondary {
            background: #f4f6f8 !important;
            color: #7b8a8b !important;
            border: 1px solid #e1e4e8;
        }

        /* Image Styling */
        .img-thumbnail {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(52, 152, 219, 0.10);
            transition: transform 0.2s;
            width: 80px;
            height: 60px;
            object-fit: cover;
        }

        .img-thumbnail:hover {
            transform: scale(1.07);
        }

        /* Button Styling */
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

        /* Pagination Styling */
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

        /* SweetAlert custom styling */
        .swal2-container .category-trash-alert.swal2-popup {
            width: 400px !important;
            font-size: 18px !important;
            padding: 10px !important;
        }

        .swal2-container .category-trash-alert .swal2-title {
            font-size: 20px !important;
            font-weight: bold !important;
        }

        .swal2-container .category-trash-alert .swal2-html-container {
            font-size: 14px !important;
            margin-bottom: 10px !important;
        }

        .swal2-container .category-trash-alert .swal2-icon {
            width: 80px !important;
            height: 80px !important;
            margin: 0 auto !important;
        }

        .swal2-container .category-trash-alert .swal2-actions {
            gap: 10px !important;
            margin: 0 !important;
        }

        .swal2-container .category-trash-alert .swal2-styled {
            padding: 8px 16px !important;
            font-size: 13px !important;
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

            h2 {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection

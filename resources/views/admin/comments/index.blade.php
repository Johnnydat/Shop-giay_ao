@extends('layouts.app')
@section('title', 'Quản lý bình luận')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách bình luận</h3>
                        <div class="card-tools">
                            <form method="GET" action="{{ route('admin.comments.index') }}">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Tìm theo nội dung bình luận" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nội dung</th>
                                    <th>Người dùng</th>
                                    <th>Sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $comment)
                                    <tr>
                                        <td>{{ ($comments->currentPage() - 1) * $comments->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $comment->content }}</td>
                                        <td>{{ $comment->user->username }}</td>
                                        <td>{{ $comment->product->name }}</td>
                                        <td>{{ $comment->status === 'active' ? 'Kích hoạt' : 'Không kích hoạt' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-gold"
                                                data-bs-toggle="modal" data-bs-target="#commentModal{{ $comment->id }}"
                                                title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form method="POST"
                                                action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <form action="{{ route('admin.categories.destroy', $comment->id) }}"
                                                    method="POST" class="delete-form d-inline"
                                                    data-id="{{ $comment->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn action-btn delete-btn" title="Xóa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="commentModal{{ $comment->id }}" tabindex="-1"
                                        aria-labelledby="commentModalLabel{{ $comment->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content text-light" style="background: #1c1e21;">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title" id="commentModalLabel{{ $comment->id }}">Chi
                                                        tiết bình luận</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" style="background-color: #fff;"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nội dung:</strong> {{ $comment->content }}</p>
                                                    <p><strong>Người dùng:</strong> {{ $comment->user->username }}</p>
                                                    <p><strong>Sản phẩm:</strong> {{ $comment->product->name }}</p>
                                                    <p><strong>Trạng thái:</strong>
                                                        <span
                                                            class="badge {{ $comment->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $comment->status === 'active' ? 'Kích hoạt' : 'Không kích hoạt' }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Ngày tạo:</strong>
                                                        {{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                                    <p><strong>Ngày cập nhật:</strong>
                                                        {{ $comment->updated_at->format('d/m/Y H:i') }}</p>

                                                    @if ($comment->replies_count > 0)
                                                        <hr class="my-3">
                                                        <h6 class="mb-3">Phản hồi ({{ $comment->replies_count }})</h6>
                                                        <div class="replies-container"
                                                            style="max-height: 300px; overflow-y: auto;">
                                                            @foreach ($comment->replies as $reply)
                                                                <div class="card mb-2 bg-dark border border-warning">
                                                                    <div class="card-body p-3 text-light">
                                                                        <div class="d-flex justify-content-between mb-2">
                                                                            <div class="d-flex align-items-center">
                                                                                @if ($reply->user && $reply->user->avatar)
                                                                                    <img src="{{ asset('storage/' . $reply->user->avatar) }}"
                                                                                        width="30" height="30"
                                                                                        class="rounded-circle border border-gold me-2"
                                                                                        style="object-fit: cover;">
                                                                                @else
                                                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2"
                                                                                        style="width: 30px; height: 30px;">
                                                                                        <i class="fas fa-user text-white"
                                                                                            style="font-size: 0.8rem;"></i>
                                                                                    </div>
                                                                                @endif
                                                                                <span>{{ $reply->user->name ?? 'Người dùng đã xóa' }}</span>
                                                                            </div>
                                                                            <small
                                                                                class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                                                        </div>
                                                                        <p class="mb-0">{{ $reply->content }}</p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="float-right">
                {{ $comments->links('pagination::bootstrap-5') }}

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
                    html: `Bạn có chắc chắn muốn <strong>xóa Bình luận</strong>"`,
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

        .btn-outline-gold {
            color: #f1c40f;
            border: 1px solid #f1c40f;
            background: transparent;
        }

        .btn-outline-gold:hover,
        .btn-outline-gold:focus {
            background: #f1c40f;
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

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
            background: #23272b;
            color: #fff;
        }

        .modal-header {
            border-bottom: 1px solid #444;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            background-color: #fff !important;
            opacity: 1;
        }

        .replies-container {
            max-height: 300px;
            overflow-y: auto;
        }

        .card.bg-dark {
            background: #23272b !important;
            border: 1px solid #f1c40f !important;
        }

        .border-gold {
            border-color: #f1c40f !important;
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

        /* SweetAlert Custom */
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

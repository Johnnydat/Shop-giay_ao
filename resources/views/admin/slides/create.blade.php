@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <h2 class="mb-4">📸 Thêm Slide Mới</h2>
        <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tiêu Đề</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                       value="{{ old('name') }}" placeholder="Nhập tiêu đề slide" aria-describedby="nameError">
                @error('name')
                    <div class="invalid-feedback" id="nameError">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Ảnh Slide</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" aria-describedby="imageError">
                @error('image')
                    <div class="invalid-feedback" id="imageError">{{ $message }}</div>
                @enderror
                <div id="imagePreview" class="mt-2" style="display: none;">
                    <img src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Trạng Thái</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                        aria-describedby="statusError">
                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hiển Thị</option>
                    <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('status')
                    <div class="invalid-feedback" id="statusError">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Tạo Slide</button>
                <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Image preview
            document.getElementById('image').addEventListener('change', function (event) {
                const preview = document.getElementById('imagePreview');
                const img = preview.querySelector('img');
                const file = event.target.files[0];
                if (file) {
                    img.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            });
        </script>
    @endpush
@endsection
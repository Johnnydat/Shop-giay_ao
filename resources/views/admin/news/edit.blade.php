@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Cập nhật tin tức</h2>
        <form action="{{ route('admin.news.update', $new->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $new->title) }}" required>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug', $new->slug) }}" placeholder="Nhập slug">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <div class="col-md-12 mb-3">
                <label class="form-label">Nội dung</label>
                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror"
                    placeholder="Nhập nội dung" style="min-height: 400px;">{{ old('content', $new->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            {{-- Thumbnail --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Hình ảnh</label>
                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                    accept="image/*">
                @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                {{-- Hiển thị ảnh hiện tại nếu có --}}
                @if ($new->thumbnail)
                    <div class="mt-2">
                        <p class="text-muted">Ảnh hiện tại:</p>
                        <img src="{{ Storage::url($new->thumbnail) }}" alt="Current thumbnail" class="img-thumbnail"
                            style="max-width: 200px; max-height: 200px;">
                    </div>
                @endif
            </div>



            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="is_published" class="form-select">
                    <option value="1" {{ $new->is_published == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ $new->is_published == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
    {{-- Summernote --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                height: 400,
                placeholder: 'Nhập nội dung'
            });
        });
    </script>
    <script>
        function generateSlug(str) {
            return str
                .toLowerCase()
                .normalize('NFD') // loại bỏ dấu tiếng Việt
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '') // loại ký tự đặc biệt
                .trim()
                .replace(/\s+/g, '-') // khoảng trắng -> -
                .replace(/-+/g, '-'); // loại bỏ nhiều dấu - liên tiếp
        }

        $(document).ready(function() {
            // Summernote
            $('#content').summernote({
                height: 400,
                placeholder: 'Nhập nội dung liên hệ'
            });

            // Tự động cập nhật slug theo title
            $('#title').on('input', function() {
                const title = $(this).val();
                const slug = generateSlug(title);
                $('input[name="slug"]').val(slug);
            });
        });
    </script>
@endsection

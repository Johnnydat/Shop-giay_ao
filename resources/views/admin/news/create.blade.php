Tạo trang thêm mới tin tức
@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="my-4">Thêm tin tức mới</h1>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Tên bài viết --}}
            <div class="col-md-12 mb-3">
                <label for="title" class="form-label">Tên Bài viết</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- slug  --}}
            <div class="col-md-12">
                <label class="form-label">Slug </label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug') }}" placeholder ="Nhập slug">
                @error('slug')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>

            {{-- Mô tả --}}
            <div class="col-md-12 mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5"></textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- Thumbnail --}}
            <div class="col-md-6">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror">
                @error('thumbnail')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>
            {{-- Trạng thái --}}
            <div class="col-md-12 mb-3">
                <label for="is_published" class="form-label">Trạng thái</label>
                <select name="is_published" id="is_published" class="form-select @error('is_published') is-invalid @enderror">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
                @error('is_published')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- Ngày tạo --}}
            <div class="col-md-12 mb-3">
                <label for="created_at" class="form-label">Ngày tạo</label>
                <input type="date" name="created_at" id="created_at"
                    class="form-control @error('created_at') is-invalid @enderror">
                @error('created_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Lưu tin tức</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Hủy</a>
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
                placeholder: 'Nhập nội dung liên hệ'
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

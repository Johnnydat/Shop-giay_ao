# tạo form sửa danh mục sản phẩm
@extends('layouts.app')
@section('title', 'Sửa danh mục sản phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Sửa danh mục sản phẩm</h2>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{--  Title --}}
            <div class="col-md-12 mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- Trạng thái --}}
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1" {{ $category->status ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ !$category->status ? 'selected' : '' }}>Khóa</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- Ảnh đại diện --}}
            <div class="col-md-6">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @if (!empty($category->image))
                    <img src="{{ asset('storage/' . $category->image) }}" alt="Ảnh cũ" width="150">
                @endif
                @error('image')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection

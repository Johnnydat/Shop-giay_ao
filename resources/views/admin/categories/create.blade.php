#tạo form thêm mới danh mục sản phẩm

@extends('layouts.app')
@section('title', 'Thêm mới danh mục sản phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Thêm mới danh mục sản phẩm</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{--  Title --}}
            <div class="col-md-12 mb-3">
                <label for="title" class="form-label">Tên danh mục</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1">Hoạt động</option>
                    <option value="0">Khóa</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection

Tạo giao diện để tạo sản phẩm mới trong trang quản trị của ứng dụng Laravel. Giao diện này bao gồm các trường nhập liệu cho tên sản phẩm, mô tả, giá, trạng thái, hình ảnh và danh mục sản phẩm. Nó cũng bao gồm các nút để lưu hoặc hủy thao tác.
@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <h2 class="mb-4">📦 Thêm sản phẩm mới</h2>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12 mb-3">
                <label for="title" class="form-label">Tên Sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1">Còn hàng</option>
                    <option value="0">Hết hàng</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kho hàng --}}
            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Kho hàng</label>
                <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
    
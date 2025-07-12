@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <h2 class="mb-4">📦 Cập nhật sản phẩm</h2>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-12 mb-3">
                <label for="title" class="form-label">Tên Sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" name="price" id="price"
                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Còn hàng</option>
                    <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Hết hàng</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @if (!empty($product->image))
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh cũ" width="150">
                @endif
                @error('image')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }} >
                                {{ $category->name }}
                            </option>
                        @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- <div class="mb-4 row">
                <label for="category_id" class="col-md-4 col-lg-3 col-form-label text-gold">
                    <i class="fas fa-list me-2"></i> Danh mục
                </label>
                <div class="col-md-8 col-lg-9">
                    <select class="form-select bg-dark border-gold text-light" name="category_id" id="category_id">
                        <option selected class="text-gold-soft">Chọn danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }} class="bg-dark">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-gold-soft mt-2"><i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div> --}}
            {{-- Kho hàng --}}
            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Kho hàng</label>
                <input type="number" name="stock" id="stock"
                    class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection

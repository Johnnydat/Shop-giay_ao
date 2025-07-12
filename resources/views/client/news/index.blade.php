@extends('layouts.appClient')
@section('title', 'Tin tức')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4 text-center">Tin tức mới nhất</h2>

        @if ($news->isEmpty())
            <div class="alert alert-info text-center">Hiện chưa có tin tức nào.</div>
        @else
            <div class="row g-4">
                @foreach ($news as $item)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if ($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" 
                                     alt="Ảnh bài viết"
                                     class="card-img-top"
                                     style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 180px;">
                                    <span class="text-secondary">Không có ảnh</span>
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title text-truncate" title="{{ $item->title }}">
                                    {{ $item->title }}
                                </h5>
                                <a href="{{ route('news.show', $item->id) }}" class="btn btn-outline-primary btn-sm mt-2">
                                    Đọc thêm
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

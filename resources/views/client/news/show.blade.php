@extends('layouts.appClient')

@section('content')
    <div class="container my-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">{{ $new->title }}</h2>

                <div class="row g-4 align-items-start">
                    <!-- Nội dung bài viết -->
                    <div class="col-lg-8">
                        <div class="mb-3" style="line-height: 1.7; text-align: justify;">
                            {!! $new->content !!}
                        </div>
                    </div>

                    <!-- Hình ảnh bài viết -->
                    <div class="col-lg-4 text-center">
                        @if ($new->thumbnail)
                            <img src="{{ asset('storage/' . $new->thumbnail) }}"
                                 alt="{{ $new->title }}"
                                 class="img-fluid rounded shadow"
                                 style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="bg-light text-secondary d-flex align-items-center justify-content-center rounded"
                                 style="height: 300px;">
                                Không có ảnh
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('news.index') }}" class="btn btn-secondary" > Quay lại</a>
    </div>
@endsection

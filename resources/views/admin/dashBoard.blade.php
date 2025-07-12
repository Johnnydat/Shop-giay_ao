@extends('layouts.app')

@section('content')
    {{-- <h1>Dashboard</h1> --}}
    <!-- Content Header -->
        <div class="content-header">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                </ol>
            </nav>
        </div>

        <!-- Page Content -->
        <div class="row">
            <!-- Stats Cards -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card admin-card border-left-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Tổng người dùng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">1,234</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card admin-card border-left-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Doanh thu
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card admin-card border-left-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Đơn hàng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">456</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card admin-card border-left-warning">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Sản phẩm
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">789</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="row">
            <div class="col-12">
                <div class="card admin-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Nội dung chính</h5>
                    </div>
                    <div class="card-body">
                        @yield('content')
                        <p>Đây là khu vực nội dung chính của trang admin. Bạn có thể thêm các component và nội dung khác vào đây.</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
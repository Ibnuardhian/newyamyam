@extends('layouts.admin')

@section('title')
    Store Dashboard
@endsection

@section('content')
<!-- Section Content -->
<div
    class="section-content section-dashboard-home"
    data-aos="fade-up"
    >
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Admin Dashboard</h2>
            <p class="dashboard-subtitle">
                Admin Panel Rumah Handuk
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-2 card">
                    <div class="card-body">
                            <div class="dashboard-card-title">
                                Jumlah User
                            </div>
                            <div class="dashboard-card-subtitle">
                                {{ $customer }}
                            </div>
                        </div>
                    <a href="{{ url('admin/user') }}" class="stretched-link"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2 card">
                    <div class="card-body rounded" style="background-color: #e19d6a; color: white;">
                            <div class="dashboard-card-title">
                                Pendapatan
                            </div>
                            <div class="dashboard-card-subtitle">
                                Rp {{ number_format($revenue, 0, ',', '.') }}
                            </div>
                        </div>
                        <a href="{{ url('admin/transaction') }}" class="stretched-link"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2 card">
                    <div class="card-body rounded" style="background-color: #3f1710; color: white;">
                            <div class="dashboard-card-title">
                                Transaksi
                            </div>
                            <div class="dashboard-card-subtitle">
                                {{ $transaction }}
                            </div>
                        </div>
                        <a href="{{ url('admin/transaction') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
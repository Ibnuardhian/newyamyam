@extends('layouts.dashboard')

@section('title')
    My Account - Yamyam Snack
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Dashboard</h2>
                <p class="dashboard-subtitle">
                    Look what you have made today!
                </p>
            </div>
            <div class="dashboard-content">
                <div class="mb-2 card">
                    <div class="card-body">
                    <div class="mb-2 card ml-2">
                        <div class="card-body">
                            <div class="dashboard-card-title">
                                Jumlah Transaksi
                            </div>
                            <div class="dashboard-card-subtitle">
                                {{ number_format($transaction_count) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 row">
                    <div class="mt-2 col-12">
                        <h5 class="mb-3">Recent Transactions</h5>
                        @foreach ($transaction_data as $transaction)
                            <a href="{{ route('dashboard-transaction-search', $transaction->code) }}"
                                class="card card-list d-block text-decoration-none">
                                <div class="card-body text-dark ">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="{{ Storage::url($transaction->transactionDetails->first()->product->galleries->first()->photos ?? '') }}"
                                                class="w-75" />
                                        </div>
                                        <div class="col-md-4">
                                            {{ $transaction->code ?? '' }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $transaction->created_at->format('d F Y') }}
                                        </div>
                                        <div class="col-md-1 d-none d-md-block">
                                            <img src="/images/dashboard-arrow-right.svg" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

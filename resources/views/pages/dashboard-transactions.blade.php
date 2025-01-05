@extends('layouts.dashboard')

@section('title')
My Account - Yamyam Snack
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transactions</h2>
                <p class="dashboard-subtitle">
                    Big result start from the small one
                </p>
            </div>
            <div class="dashboard-content">
                <div class="mb-2 card">
                    <div class="card-body">
                        <div class="dashboard-card-title">
                            Transaction
                        </div>
                        <div class="dashboard-card-subtitle">
                            {{ number_format($transaction_count) }}
                        </div>
                    </div>
                </div>
                <div class="row mb-3 justify-content-end">
                    <div class="col-md-3">
                        <form action="{{ route('dashboard-transaction') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="keyword" placeholder="Search transactions..." value="{{ $keyword }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-2 col-12">
                        <div>
                            @forelse ($buyTransactions as $transaction)
                                @if ($transaction->transaction && $transaction->transaction->code !== 'N/A')
                                    <a href="{{ route('dashboard-transaction-details', $transaction->id) }}"
                                        class="card card-list d-block text-decoration-none">
                                        <div class="card-body text-dark ">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                                        class="w-50" />
                                                </div>
                                                <div class="col-md-2">
                                                    {{ $transaction->transaction->code }}
                                                </div>
                                                <div class="col-md-4">
                                                    {{ ucfirst($transaction->product->name) }}
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
                                @endif
                            @empty
                                <div class="py-5 text-center col-12" data-aos="fade-up" data-aos-delay="100">
                                    No Transactions Found
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

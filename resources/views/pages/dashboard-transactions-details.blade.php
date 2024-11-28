@extends('layouts.dashboard')

@section('title')
    Store Dashboard Transaction Detail
@endsection

@section('content')
<!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
  <div class="container-fluid">
    <div class="dashboard-heading">
      <h2 class="dashboard-title">#{{ $transaction->code }}</h2>
      <p class="dashboard-subtitle">Rincian Transaksi</p>
    </div>
    <div class="dashboard-content" id="transactionDetails">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <!-- Transaction Details -->
              <div class="row">
                <div class="col-12 col-md-4">
                  <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}" class="mb-3 w-100" alt="" />
                </div>
                <div class="col-12 col-md-8">
                  <div class="row">
                    <div class="col-12 col-md-6">
                      <div class="product-title">Nama Pelanggan</div>
                      <input type="text" class="form-control" value="{{ $transaction->transaction->user->name }}" disabled>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="product-title">Nama Produk</div>
                      <input type="text" class="form-control" value="{{ $transaction->product->name }}" disabled>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="product-title">Tanggal Transaksi</div>
                      <input type="text" class="form-control" value="{{ $transaction->created_at }}" disabled>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="product-title">Payment Status</div>
                      <input type="text" class="form-control text-danger" value="{{ $transaction->transaction->transaction_status }}" disabled>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="product-title">Jumlah Total</div>
                      <input type="text" class="form-control" value="Rp {{ number_format($transaction->transaction->total_price) }}" disabled>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="product-title">Nomor HP</div>
                      <input type="text" class="form-control" value="{{ $transaction->transaction->user->phone_number }}" disabled>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Shipping Information -->
              <form action="{{ route('dashboard-transaction-update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                  <div class="col-12">
                    <h5>Informasi Pengiriman</h5>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="product-title">Alamat I</div>
                    <input type="text" class="form-control" value="{{ $transaction->transaction->user->address_one }}" disabled>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="product-title">Alamat II</div>
                    <input type="text" class="form-control" value="{{ $transaction->transaction->user->address_two }}" disabled>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="product-title">Provinsi</div>
                    <input type="text" class="form-control" value="{{ App\Models\Province::find($transaction->transaction->user->provinces_id)->name }}" disabled>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="product-title">Kota</div>
                    <input type="text" class="form-control" value="{{ App\Models\Regency::find($transaction->transaction->user->regencies_id)->name }}" disabled>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="product-title">Kode Pos</div>
                    <input type="text" class="form-control" value="{{ $transaction->transaction->user->zip_code }}" disabled>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="product-title">Kecamatan</div>
                    <input type="text" class="form-control" value="{{ App\Models\District::find($transaction->transaction->user->district_id)->name }}" disabled>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="product-title">Shipping Status</div>
                    <input type="text" class="form-control" value="{{ $transaction->shipping_status }}" disabled>
                  </div>
                  <template v-if="status == 'SHIPPED'">
                    <div class="col-12 col-md-3">
                      <div class="product-title">Nomor Resi</div>
                      <input type="text" class="form-control" value="{{ $transaction->resi }}" disabled>
                    </div>
                  </template>
                </div>
              </form>
              <!-- End of Shipping Information -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<script>
  var transactionDetails = new Vue({
    el: "#transactionDetails",
    data: {
      status: "{{ $transaction->shipping_status }}",
      resi: "{{ $transaction->resi }}",
    },
  });
</script>
@endpush
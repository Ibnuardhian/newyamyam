@extends('layouts.admin')

@section('title')
  Pengaturan Toko
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
        <h2 class="dashboard-title">Transaksi</h2>
        <p class="dashboard-subtitle">
            Edit Transaksi "{{ $item->user->name }}" 
        </p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-12">
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <form action="{{ route('transaction.update', $item->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Transaction Status</label>
                      <select name="transaction_status" class="form-control">
                        <option value="{{ $item->transaction_status }}">{{ $item->transaction_status }}</option>
                        <option value="" disabled>----------------</option>
                        <option value="PENDING">PENDING</option>
                        <option value="SHIPPING">SHIPPING</option>
                        <option value="SUCCESS">SUCCESS</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Total Harga</label>
                      <input type="number" class="form-control" name="total_price" value="{{ $item->total_price }}" required />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="text-right col">
                    <button
                      type="submit"
                      class="px-5 btn btn-success"
                    >
                      Simpan
                    </button>
                  </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@push('addon-script')
  <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('editor');
  </script>
@endpush
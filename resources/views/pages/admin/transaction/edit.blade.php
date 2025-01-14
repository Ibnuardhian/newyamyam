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
            <input type="hidden" name="transaction_id" value="{{ $item->id }}">
            <input type="hidden" name="transaction_status" value="{{ $item->transaction_status }}">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Transaction Status</label>
                      <select name="transaction_status" class="form-control" id="transaction_status">
                        <option value="{{ $item->transaction_status }}">{{ $item->transaction_status }}</option>
                        <option value="" disabled>----------------</option>
                        <option value="PENDING">PENDING</option>
                        <option value="SHIPPING">SHIPPING</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12" id="tracking_code_input" style="display: none;">
                    <div class="form-group">
                      <label>Tracking Code</label>
                      <input type="text" class="form-control" name="tracking_code" value="{{ $item->transactionDetails->first()->resi ?? '' }}" />
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
  <script>
    document.getElementById('transaction_status').addEventListener('change', function() {
      var trackingCodeInput = document.getElementById('tracking_code_input');
      if (this.value === 'SHIPPING') {
        trackingCodeInput.style.display = 'block';
      } else {
        trackingCodeInput.style.display = 'none';
      }
    });

    // Trigger change event on page load to handle pre-selected value
    document.getElementById('transaction_status').dispatchEvent(new Event('change'));
  </script>
@endpush
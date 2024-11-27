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
        <h2 class="dashboard-title">Produk</h2>
        <p class="dashboard-subtitle">
            Edit Produk "{{ $item->name }}"
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
          <form action="{{ route('product.update', $item->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama Produk</label>
                      <input type="text" class="form-control" name="name" value="{{ $item->name }}" required />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Kategori Produk</label>
                      <select name="categories_id" class="form-control">
                        <option value="{{ $item->categories_id }}">{{ $item->category->name }}</option>
                        <option value="" disabled>----------------</option>
                        @foreach ($categories as $categories)
                          <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Harga</label>
                      <input type="number" class="form-control" name="price" value="{{ $item->price }}" required />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Berat (gram)</label>
                      <input type="text" class="form-control" name="weight" value="{{ $item->weight }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Jumlah Stok</label>
                      <input type="text" class="form-control" name="stock_qty" value="{{ $item->stock_qty }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Ambang Batas Stok Rendah</label>
                      <input type="text" class="form-control" name="low_stock_threshold" value="{{ $item->low_stock_threshold }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Status Ketersediaan</label>
                      <select name="instock_status" class="form-control" required>
                        <option value="1" {{ $item->instock_status == 1 ? 'selected' : '' }}>TERSEDIA</option>
                        <option value="0" {{ $item->instock_status == 0 ? 'selected' : '' }}>HABIS</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Deskripsi</label>
                      <textarea name="description" id="editor">{!! $item->description !!}</textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="text-right col">
                    <button
                      type="submit"
                      class="px-5 btn btn-primary"
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
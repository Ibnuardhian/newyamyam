@extends('layouts.admin')

@section('title')
Pengaturan Toko
@endsection

@section('content')
<!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Diskon</h2>
            <p class="dashboard-subtitle">
                Buat Diskon Baru
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
                    <form action="{{ route('discount.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nama Diskon</label>
                                            <input type="text" class="form-control" name="name" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Kode Diskon</label>
                                            <input type="text" class="form-control" name="code" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Jenis Diskon</label>
                                            <select class="form-control" name="discount_type" required>
                                                <option value="percentage">Persentase (Termasuk ongkir)</option>
                                                <option value="percentageproduct" id="persen">Persentasi (Produk saja)</option>
                                                <option value="fixed" id="persen">Tetap</option>
                                                <option value="ongkir" id="fix">Gratis Ongkir</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nilai Diskon</label>
                                            <input type="number" class="form-control" name="discount_value" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Biaya Pengiriman</label>
                                            <input type="number" class="form-control" name="shipping_cost" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" class="form-control" name="start_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Tanggal Berakhir</label>
                                            <input type="date" class="form-control" name="end_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Pembelian Minimum</label>
                                            <input type="number" class="form-control" name="minimum_purchase" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Batas Penggunaan</label>
                                            <input type="number" class="form-control" name="usage_limit" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Aktif</label>
                                            <select class="form-control" name="is_active" required>
                                                <option value="true">Ya</option>
                                                <option value="false">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-right col">
                                        <button type="submit" class="px-5 btn btn-success">
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
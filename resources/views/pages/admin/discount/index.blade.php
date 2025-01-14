@extends('layouts.admin')

@section('title')
    Diskon
@endsection

@section('content')
<!-- Section Content -->
<div
    class="section-content section-dashboard-home"
    data-aos="fade-up"
    >
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Diskon</h2>
            <p class="dashboard-subtitle">
                Daftar Diskon
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('discount.create') }}" class="btn btn-primary mb-3">
                                + Tambah Diskon Baru
                            </a>
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode</th>
                                        <th>Jenis Diskon</th>
                                        <th>Nilai Diskon</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script>
        // AJAX DataTable
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'discount_type', name: 'discount_type' },
                { data: 'discount_value', name: 'discount_value',
                    render: function (data, type, row) {
                        return new Intl.NumberFormat('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }).format(data);
                    }
                },
                { data: 'start_date', name: 'start_date', render: function (data, type, row) {
                    var date = new Date(data);
                    var day = ("0" + date.getDate()).slice(-2);
                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                    var month = monthNames[date.getMonth()];
                    var year = date.getFullYear();
                    return day + ' ' + month + ' ' + year;
                } },
                { data: 'end_date', name: 'end_date', render: function (data, type, row) {
                    var date = new Date(data);
                    var day = ("0" + date.getDate()).slice(-2);
                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                    var month = monthNames[date.getMonth()];
                    var year = date.getFullYear();
                    return day + ' ' + month + ' ' + year;
                } },
                { 
                    data: 'is_active', 
                    name: 'is_active',
                    render: function(data, type, row) {
                        return data == 1 ? 'Ya' : 'Tidak';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ]
        });
    </script>
@endpush
@extends('layouts.dashboard')

@section('title')
My Account - Yamyam Snack
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Account</h2>
                <p class="dashboard-subtitle">
                    Update your current profile
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <form id="locations"
                            action="{{ route('dashboard-settings-redirect', 'dashboard-settings-account') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="previous_regencies_id" id="previous_regencies_id" value="{{ $user->regencies_id }}">
                            <input type="hidden" name="previous_district_id" id="previous_district_id" value="{{ $user->district_id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Username</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $user->name) }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ old('email', $user->email) }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_one">Alamat 1</label>
                                                <input type="text" class="form-control" id="address_one"
                                                    name="address_one" value="{{ old('address_one', $user->address_one) }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_two">Catatan untuk kurir</label>
                                                <input type="text" class="form-control" id="address_two"
                                                    name="address_two" value="{{ old('address_two', $user->address_two) }}" />
                                                    <span style="font-size: smaller; display: block;">Warna rumah, patokan, pesan khusus, dll.</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="provinces_id">Provinsi</label>
                                                <select name="provinces_id" id="provinces_id" class="form-control" v-model="provinces_id">
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ $province->id == old('provinces_id', $user->provinces_id) ? 'selected' : '' }}>{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="regencies_id">Kota</label>
                                                <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id">
                                                    <option v-for="regency in regencies" :key="regency.id" :value="regency.id"> @{{ regency.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="districts_id">Kecamatan</label>
                                                <select name="district_id" id="district_id" class="form-control" v-model="district_id">
                                                    <option v-for="district in districts" :key="district.id" :value="district.id">@{{ district.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="zip_code">Kode Pos</label>
                                                <input type="text" class="form-control" id="zip_code" name="zip_code"
                                                    value="{{ old('zip_code', $user->zip_code) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_number">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number" value="{{ old('phone_number', substr($user->phone_number, 0, 4) . '-' . substr($user->phone_number, 4, 4) . '-' . substr($user->phone_number, 8)) }}" 
                                                    v-model="formattedPhoneNumber" @input="formatPhoneNumber" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-right col">
                                            <button type="submit" class="px-5 btn btn-primary" @click="setPreviousValues">
                                                Simpan
                                            </button>
                                        </div>
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
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var locations = new Vue({
            el: "#locations",
            mounted() {
                this.getProvincesData();
                if (this.provinces_id) {
                    this.getRegenciesData();
                }
                if (this.regencies_id) {
                    this.getDistrictsData();
                }
            },
            data: {
                provinces: @json($provinces),
                regencies: @json($regencies),
                districts: @json($districts),
                provinces_id: "{{ $user->provinces_id }}",
                regencies_id: "{{ $user->regencies_id }}",
                district_id: "{{ $user->district_id }}",
                formattedPhoneNumber: "{{ $user->phone_number }}",
            },
            methods: {
                getProvincesData() {
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                        .then(function(response) {
                            self.provinces = response.data;
                        })
                },
                getRegenciesData() {
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                        .then(function(response) {
                            self.regencies = response.data;
                        })
                },
                getDistrictsData() {
                    var self = this;
                    axios.get('{{ url('api/districts') }}/' + self.regencies_id)
                        .then(function(response) {
                            self.districts = response.data;
                        })
                },
                setPreviousValues() {
                    document.getElementById('previous_regencies_id').value = this.regencies_id;
                    document.getElementById('previous_district_id').value = this.district_id;
                },
                formatPhoneNumber() {
                    // Add phone number formatting logic here if needed
                }
            },
            watch: {
                provinces_id: function(val, oldVal) {
                    this.regencies_id = null;
                    this.district_id = null;
                    this.getRegenciesData();
                },
                regencies_id: function(val, oldVal) {
                    this.district_id = null;
                    this.getDistrictsData();
                },
            }
        });
    </script>
@endpush

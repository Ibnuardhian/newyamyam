@extends('layouts.dashboard')

@section('title')
    Account Settings
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
                                                <label for="name">Your Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $user->name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Your Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_one">Address 1</label>
                                                <input type="text" class="form-control" id="address_one"
                                                    name="address_one" value="{{ $user->address_one }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_two">Address 2</label>
                                                <input type="text" class="form-control" id="address_two"
                                                    name="address_two" value="{{ $user->address_two }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="provinces_id">Provinsi</label>
                                                <select name="provinces_id" id="provinces_id" class="form-control" v-model="provinces_id">
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ $province->id == $user->provinces_id ? 'selected' : '' }}>{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="regencies_id">Kota</label>
                                                <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id">
                                                <option v-for="regency in regencies" :key="regency.id" :value="regency.id":selected="regency.id === {{ $user->regencies_id }}"> @{{ regency.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="districts_id">Kecamatan</label>
                                                <select name="district_id" id="district_id" class="form-control" v-model="district_id">
                                                <option v-for="district in districts" :key="district.id" :value="district.id":selected="district.id === {{ $user->district_id }}">@{{ district.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="zip_code">Kode Pos</label>
                                                <input type="text" class="form-control" id="zip_code" name="zip_code"
                                                    value="{{ $user->zip_code }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_number">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number" value="{{ $user->phone_number }}" />
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
                regencies: [],
                districts: [],
                provinces_id: "{{ $user->provinces_id }}",
                regencies_id: "{{ $user->regencies_id }}",
                district_id: "{{ $user->district_id }}",
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

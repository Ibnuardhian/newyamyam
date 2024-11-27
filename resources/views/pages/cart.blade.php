@extends('layouts.app')

@section('title')
    Store Cart Page
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
      <section>
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="{{route('home')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item active">
                    Cart
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-cart">
        <div class="container">
          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12 table-responsive">
              <table class="table table-borderless table-cart">
                <thead>
                  <tr>
                    <td>Gambar</td>
                    <td>Nama Produk</td>
                    <td>Harga</td>
                    <td>Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  @php $totalPrice = 0 @endphp
                  @foreach ($carts as $cart)
                    <tr>
                      <td style="width: 20%;">
                        @if($cart->product->galleries)
                          <img
                            src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                            alt=""
                            class="cart-image"
                          />
                        @endif
                      </td>
                      <td style="width: 35%;">
                        <div class="product-title">{{ ucfirst($cart->product->name) }}</div>
                      </td>
                      <td style="width: 35%;">
                        <div class="product-title">Rp {{ number_format($cart->product->price) }}</div>
                      </td>
                      <td style="width: 20%;">
                        <form action="{{ route('cart-delete', $cart->products_id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-remove-cart" type="submit">
                            Remove
                          </button>
                        </form>
                      </td>
                    </tr>
                    @php $totalPrice += $cart->product->price @endphp
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12">
              <h2 class="mb-4">Shipping Details</h2>
            </div>
          </div>
          <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
            <div class="mb-2 row" data-aos="fade-up" data-aos-delay="200" id="locations">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address_one">Address 1</label>
                  <input
                    type="text"
                    class="form-control"
                    id="address_one"
                    name="address_one"
                    value="{{ $user->address_one }}"
                    disabled
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                <label for="address_two">Catatan untuk kurir</label>
                  <input
                    type="text"
                    class="form-control"
                    id="address_two"
                    name="address_two"
                    value="{{ $user->address_two }}"
                    disabled
                  />
                  <span style="font-size: smaller; display: block;">Warna rumah, patokan, pesan khusus, dll.</span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="provinces_id">Province</label>
                  <select name="provinces_id" id="provinces_id" class="form-control" v-model="provinces_id" disabled>
                    @foreach ($provinces as $province)
                      <option value="{{ $province->id }}" {{ $province->id == $user->provinces_id ? 'selected' : '' }}>{{ $province->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="regencies_id">City</label>
                  <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id" disabled>
                    <option v-for="regency in regencies" :key="regency.id" :value="regency.id" :selected="regency.id === {{ $user->regencies_id }}">@{{ regency.name }}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="zip_code">Postal Code</label>
                  <input
                    type="text"
                    class="form-control"
                    id="zip_code"
                    name="zip_code"
                    value="{{ $user->zip_code }}"
                    disabled
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="country">Country</label>
                  <input
                    type="text"
                    class="form-control"
                    id="country"
                    name="country"
                    value="Indonesia"
                    disabled
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="phone_number">Mobile</label>
                  <input
                    type="text"
                    class="form-control"
                    id="phone_number"
                    name="phone_number"
                    value="{{ substr($user->phone_number, 0, 4) . '-' . substr($user->phone_number, 4, 4) . '-' . substr($user->phone_number, 8) }}"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="150">
              <div class="col-12">
                <hr />
              </div>
              <div class="col-12">
                <h2 class="mb-1">Payment Informations</h2>
              </div>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="200">
              <div class="col-4 col-md-2">
                <div class="product-title">Rp 0</div>
                <div class="product-subtitle">Pajak</div>
              </div>
              <div class="col-4 col-md-3">
                <div class="product-title">Rp 0</div>
                <div class="product-subtitle">Asuransi Produk</div>
              </div>
              <div class="col-4 col-md-2">
                <div class="product-title">Rp 0</div>
                <div class="product-subtitle">Biaya Pengiriman</div>
              </div>
              <div class="col-4 col-md-2">
                <div class="product-title text-success">Rp {{ number_format($totalPrice ?? 0) }}</div>
                <div class="product-subtitle">Total</div>
              </div>
              <div class="col-8 col-md-3">
                <button
                  type="submit"
                  class="px-4 mt-4 btn btn-success btn-block"
                >
                  Checkout Now
                </button>
              </div>
            </div>
          </form>
        </div>
      </section>
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
          this.provinces = @json($provinces);
          this.regencies = @json($regencies);
        },
        data: {
          provinces: [],
          regencies: [],
          provinces_id: "{{ $user->provinces_id }}",
          regencies_id: "{{ $user->regencies_id }}",
        },
        methods: {
          // No need to fetch data from API
        },
        watch: {
          provinces_id: function (val, oldVal) {
            this.regencies_id = null;
            this.regencies = this.provinces.find(province => province.id == val).regencies;
          },
        }
      });
    </script>
@endpush
@extends('layouts.app')

@section('title')
    Cart - Yamyam Snack
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
      <section
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
              <table class="table table-borderless table-cart text-center">
                <thead>
                  <tr>
                    <td>Gambar</td>
                    <td>Nama Produk</td>
                    <td>Harga</td>
                    <td>Jumlah</td>
                    <td>Subtotal</td>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $totalWeight = 0;
                    $totalPrice = 0;
                    $shippingCost = 0;
                  @endphp
                  @foreach ($carts as $cart)
                    @php
                      $totalWeight += $cart->product->weight * $cart->qty;
                      $totalPrice += $cart->product->price * $cart->qty;
                    @endphp
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
                      <td style="width: 20%;">
                        <div class="product-title text-left">{{ ucfirst($cart->product->name) }}</div>
                      </td>
                      <td style="width: 15%;">
                        <div class="product-title">Rp {{ number_format($cart->product->price, 0, '.', '.') }}</div>
                      </td>
                      <td style="width: 15%;">
                        <div class="product-title">
                            <form action="{{ route('cart-update', $cart->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <div class="input-group">
                              <div class="input-group-prepend">
                              <button class="btn btn-secondary" type="button" onclick="updateQty(this, -1)">-</button>
                              </div>
                              <input type="text" name="qty" value="{{ $cart->qty }}" min="1" class="form-control qty-input text-center" oninput="this.value = this.value.replace(/[^0-9]/g, ''); debounceUpdate(this)">
                              <div class="input-group-append">
                              <button class="btn btn-secondary" type="button" onclick="updateQty(this, 1)">+</button>
                              </div>
                            </div>
                            </form>
                        </div>
                      </td>
                      <td style="width: 20%;">
                        <div class="product-title">Rp {{ number_format($cart->product->price * $cart->qty, 0, '.', '.') }}</div>
                      </td>
                      <td style="width: 20%;">
                        <button class="btn btn-remove-cart" type="button" onclick="confirmDelete({{ $cart->id }})">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $cart->id }}" action="{{ route('cart-delete', $cart->id) }}" method="POST" style="display: none;">
                          @method('DELETE')
                          @csrf
                        </form>
                      </td>
                    </tr>
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
              <h2 class="mb-4">Detail Pengiriman</h2>
            </div>
          </div>
          <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
            <input type="hidden" name="shipping_cost" value="0">
            <div class="mb-2 row" data-aos="fade-up" data-aos-delay="200" id="locations">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address_one">Alamat</label>
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
              <div class="col-md-3">
                <div class="form-group">
                  <label for="provinces_id">Province</label>
                  <select name="provinces_id" id="provinces_id" class="form-control" v-model="provinces_id" disabled>
                    @foreach ($provinces as $province)
                      <option value="{{ $province->id }}" {{ $province->id == $user->provinces_id ? 'selected' : '' }}>{{ $province->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="regencies_id">City</label>
                  <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id" disabled>
                    <option v-for="regency in regencies" :key="regency.id" :value="regency.id" :selected="regency.id === regencies_id">@{{ regency.name }}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
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
              <div class="col-md-3">
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
              <div class="product-subtitle">Diskon Produk</div>
              </div>
              <div class="col-4 col-md-2">
              <div class="product-title" id="shipping-cost">Rp 0</div>
              <div class="product-subtitle" id="shipping-service">JNE - REG (1-2 hari)</div>
              <div class="product-subtitle" id="shipping-service">Biaya Pengiriman</div>
              </div>
              <div class="col-4 col-md-2">
              <div class="product-title text-success">Rp {{ number_format($totalPrice + $shippingCost, 0, '.', '.') }}</div>
              <div class="product-subtitle">Total</div>
              </div>
              <div class="col-8 col-md-3">
                <button
                  type="submit"
                  class="px-4 mt-4 btn btn-primary btn-block"
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
        },
        watch: {
          provinces_id: function (val, oldVal) {
            this.regencies_id = null;
            this.regencies = this.provinces.find(province => province.id == val).regencies;
          },
        }
      });

      function debounce(func, wait) {
        let timeout;
        return function(...args) {
          const context = this;
          clearTimeout(timeout);
          timeout = setTimeout(() => func.apply(context, args), wait);
        };
      }

      function debounceUpdate(input) {
        debounce(function() {
          input.form.submit();
        }, 2000)();
      }

      function updateQty(button, increment) {
        const input = button.parentElement.parentElement.querySelector('.qty-input');
        const newValue = parseInt(input.value) + increment;
        if (newValue >= 1) {
          input.value = newValue;
          debounceUpdate(input);
        } else {
          confirmDelete(button.closest('tr').querySelector('form').id.split('-').pop());
        }
      }

      function confirmDelete(cartId) {
        if (confirm("Apakah yakin ingin menghapus produk dari keranjang?")) {
          document.getElementById('delete-form-' + cartId).submit();
        }
      }

      async function calculateShippingCost() {
        try {
          const response = await axios.post("{{ route('calculate-shipping') }}", {
            origin: "{{ config('services.rajaongkir.origin') }}",
            destination: "{{ DB::table('regencies_combined')->where('regencies_id', $user->regencies_id)->value('regency_rajaongkir_id') }}",
            weight: {{ $totalWeight }},
            courier: "jne"
          });
          const shippingCost = response.data.cost;
          const shippingService = response.data.service;
          const shippingETD = response.data.etd;
          if (shippingCost) {
            document.getElementById('shipping-cost').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
            document.getElementById('shipping-service').innerText = 'JNE - ' + shippingService + ' ( ' + shippingETD + ' hari)';
            document.querySelector('input[name="shipping_cost"]').value = shippingCost;
            document.querySelector('.product-title.text-success').innerText = 'Rp ' + ({{ $totalPrice }} + shippingCost).toLocaleString('id-ID');
          }
        } catch (error) {
          console.error("Error calculating shipping cost:", error);
        }
      }

      document.addEventListener('DOMContentLoaded', function() {
        calculateShippingCost();
      });
    </script>
@endpush
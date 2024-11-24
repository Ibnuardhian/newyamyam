@extends('layouts.app')

@section('title')
    Store Detail Page
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-details">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Product Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-3 store-gallery" id="gallery">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6" data-aos="zoom-in">
                        <transition name="slide-fade" mode="out-in">
                            <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="main-image d-block mx-auto mb-3" alt="Product Image" width="250" height="250" />
                        </transition>
                        <div class="row">
                            <div class="col-3 col-lg-3" v-for="(photo, index) in photos" :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                                <a href="#" @click.prevent="changeActive(index)">
                                    <img :src="photo.url" class="thumbnail-image" :class="{ active: index == activePhoto }" alt="Thumbnail Image" style="width: 100%;"/>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="store-details-container" data-aos="fade-up">
                            <section class="store-heading">
                                <h1 class="products-name">{{ ucwords($product->name) }}</h1>
                                <div class="price products-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </section>
                            <section class="store-description mt-4">
                                {!! $product->description !!}
                            </section>
                            @auth
                                <form action="{{ route('detail-add', $product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <button type="submit" class="px-4 mb-3 btn btn-primary btn-block">
                                        Tambahkan ke keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="px-4 mb-3 btn btn-secondary btn-block">
                                    Login to Add
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('addon-style')
    <style>
        .product-name {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .product-price {
            font-size: 1.5rem;
            color: #ff5722;
        }
    </style>
@endpush

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
        var gallery = new Vue({
            el: "#gallery",
            mounted() {
                AOS.init();
            },
            data: {
                activePhoto: 0,
                photos: [
                    @foreach ($product->galleries as $gallery)
                        {
                            id: {{ $gallery->id }},
                            url: "{{ Storage::url($gallery->photos) }}",
                        },
                    @endforeach
                ],
            },
            methods: {
                changeActive(id) {
                    this.activePhoto = id;
                },
            },
        });
    </script>
    <script src="/script/navbar-scroll.js"></script>
@endpush

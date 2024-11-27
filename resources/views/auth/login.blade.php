@extends('layouts.auth')

@section('content')
<div class="page-content page-auth">
    <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center row-login">
                <div class="text-center col-lg-6">
                    <img src="/images/login-placeholder.png" alt="" class="mb-4 w-50 mb-lg-none" />
                </div>
                <div class="col-lg-5">
                    <h2>
                        Snack berkualitas, <br />
                        hanya untuk kamu yang menginginkan rasa terbaik!
                    </h2>
                    <form method="POST" action="{{ route('login') }}" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <label>Alamat Email</label>
                            <input id="email" type="email"
                                class="form-control w-75 @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kata Sandi</label>
                            <input id="password" type="password"
                                class="form-control w-75 @error('password') is-invalid @enderror" name="password"
                                required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="mt-4 btn btn-primary btn-block w-75">
                            Login to My Account
                        </button>
                        <div class="d-flex justify-content-between align-items-center mt-4 w-75">
                            <span>Belum punya akun?
                                <a href="{{ route('register') }}" class="btn btn-info ml-1">Daftar</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.success')

@section('title')
    Store Success Page
@endsection

@section('content')
    <div class="page-content page-success">
      <div class="section-success" data-aos="zoom-in">
        <div class="container">
          <div class="row align-items-center row-login justify-content-center">
            <div class="text-center col-lg-6">
              <img src="/images/success.svg" alt="" class="mb-4" />
              <h2>
                Transaction Processed!
              </h2>
              <p>
                Silahkan tunggu konfirmasi email dari kami dan kami akan
                menginformasikan resi secept mungkin!
              </p>
              <div>
                <a href="{{route('dashboard')}}" class="mt-4 btn btn-success w-50">
                  My Dashboard
                </a>
                <a href="{{route('home')}}" class="mt-2 btn btn-signup w-50">
                  Go To Shopping
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
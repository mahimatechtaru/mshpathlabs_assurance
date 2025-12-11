@extends('layout.mainlayout_admin',['activePage' => 'login'])

@section('title',__('Doctor login'))

@section('content')
<section class="section">
  <div class="d-flex flex-wrap align-items-stretch">
    <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
      <div class="p-4 m-3">
        @php
        $setting = App\Models\Setting::first();
        @endphp
        @if(isset($setting->logo))
        <img src="{{ $setting->logo }}" alt="logo" width="180" class="mb-5 mt-2">
        @else
        <img src="{{url('/images/upload_empty/logo_black.png')}}" alt="logo" width="180" class="mb-5 mt-2" />
        @endif
        @if ($errors->any())
        @foreach ($errors->all() as $item)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ $item }}
        </div>
        @endforeach
        @endif
        <form action="{{ url('doctor/verify_doctor') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="email">{{__('Email') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" required autofocus>
            @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group">
            <div class="d-block">
              <label for="password" class="control-label">{{__('Password') }}</label>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" required>
            @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group text-right">
            <a href="{{url('doctor_forgot_password')}}" class="float-left mt-3">
              {{__('Forgot Password?') }}
            </a>
            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
              {{__('Login')}}
            </button>
          </div>
        </form>
        <div class="text-center mt-5">
          {{__("does not have an account?")}}<a href="{{ url('doctor/doctor_signup') }}">&nbsp;{{__('SignUp')}}</a>
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{ url('assets/img/login.png') }}">
      <div class="absolute-bottom-left index-2">
        <div class="text-light p-5 pb-2">
          <div class="mb-5 pb-3">
            <h1 class="mb-2 display-4 font-weight-bold">{{__('Welcome') }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

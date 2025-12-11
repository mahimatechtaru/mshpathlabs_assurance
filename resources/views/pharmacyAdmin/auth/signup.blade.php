@extends('layout.mainlayout_admin',['activePage' => 'login'])

@section('title',__('Pharmacy Register'))

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
        <img src="{{url('/images/upload_empty/logo_black.png')}}" class="h-6 mr-3 sm:h-9" alt="Doctro Logo" />
        @endif
        @if ($errors->any())
        @foreach ($errors->all() as $item)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ $item }}
        </div>
        @endforeach
        @endif
        <form action="{{ url('pharmacy_register') }}" method="post">
          @csrf
          <div class="form-group">
            <label class="col-form-label">{{ __('Name') }}</label>
            <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label class="col-form-label">{{ __('Email') }}</label>
            <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label class="col-form-label">{{ __('Password') }}</label>
            <input type="password" value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <label class="col-form-label">{{ __('Phone number') }}</label><br>
          <div class="form-group d-flex @error('phone') is-invalid @enderror">
            <select name="phone_code" class="phone_code_select2">
              @foreach ($countries as $country)
              <option value="+{{$country->phonecode}}" {{(old('phone_code') == $country->phonecode) ? 'selected':''}}>+{{ $country->phonecode }}</option>
              @endforeach
            </select>
            <input type="number" name="phone" class="form-control" value="{{ old('phone') }}">
          </div>
          @error('phone')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
          <label class="col-form-label mt-2">{{ __('Location Based  On Latitude/Longitude') }}</label>
          <div class="row">
            <div class="col-md-12">
              <div class="pac-card" id="pac-card">
                <div id="pac-container">
                  <input id="pac-input" type="text" name="address" class="form-control" placeholder="{{__('Location')}}" />
                  <input type="hidden" name="lat" value="{{$setting->lat}}" id="lat">
                  <input type="hidden" name="lang" value="{{$setting->lang}}" id="lng">
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div id="map" class="mapClass"></div>
            </div>
          </div>
          <div class="form-group mt-2 text-right">
            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
              {{ __('Register')}}
            </button>
          </div>

          <div class="mt-5 text-center">
            {{__("Already have an account?")}} <a href="{{ url('pharmacy_login') }}">{{ __('Login')}}</a>
          </div>
        </form>
      </div>
    </div>
    <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{ url('assets/img/login.png') }}">
      <div class="absolute-bottom-left index-2">
        <div class="text-light p-5 pb-2">
          <div class="mb-5 pb-3">
            <h1 class="mb-2 display-4 font-weight-bold">{{ __('Welcome') }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
<script src="{{ url('assets_admin/js/hospital_map.js') }}"></script>
@endsection

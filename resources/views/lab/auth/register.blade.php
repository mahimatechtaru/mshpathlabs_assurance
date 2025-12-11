@extends('layout.mainlayout_admin',['activePage' => 'login'])

@section('title', __('Pathologist signup'))

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
                    <form method="POST" action="{{ url('verify_sign_up') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <label for="lab_image" class="col-form-label"> {{ __('Laboratory image') }}</label>
                                <div class="avatar-upload avatar-box avatar-box-left">
                                    <div class="avatar-edit">
                                        <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                        <label for="image"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview">
                                        </div>
                                    </div>
                                </div>
                                @error('image')
                                    <div class="custom_error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Laboratory Name') }}</label>
                                    <input type="text" required value="{{ old('lab_name') }}" name="lab_name"
                                        class="form-control @error('lab_name') is-invalid @enderror">
                                    @error('lab_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Pathologist name') }}</label>
                                    <input type="text" value="{{ old('user_name') }}" name="user_name"
                                        class="form-control @error('user_name') is-invalid @enderror">
                                    @error('user_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6 form-group">
                                <label for="phone_number" class="col-form-label"> {{ __('Phone number') }}</label>
                                <div class="d-flex @error('phone') is-invalid @enderror">
                                    <select name="phone_code" class="phone_code_select2">
                                        @foreach ($countries as $country)
                                            <option value="+{{ $country->phonecode }}"
                                                {{ old('phone_code') == $country->phonecode ? 'selected' : '' }}>
                                                +{{ $country->phonecode }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" min="1" name="phone" class="form-control"
                                        value="{{ old('phone') }}">
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="email" class="col-form-label"> {{ __('Email') }}</label>
                                <input type="email" value="{{ old('email') }}" name="email"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 form-group">
                                <label class="col-form-label">{{ __('Start Time') }}</label>
                                <input class="form-control timepicker @error('start_time') is-invalid @enderror"
                                    name="start_time" value="{{ old('start_time') }}" type="time">
                                @error('start_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="col-form-label">{{ __('End Time') }}</label>
                                <input class="form-control timepicker @error('end_time') is-invalid @enderror"
                                    name="end_time" value="{{ old('end_time') }}" type="time">
                                @error('end_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">{{ __('Password') }}</label>
                            <input class="form-control @error('password') is-invalid @enderror" name="password" type="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mt-4">
                            <div class="pac-card col-md-12 mb-3" id="pac-card">
                                <label
                                    for="pac-input col-form-label">{{ __('Location based on latitude/longitude') }}</label>
                                <div id="pac-container">
                                    <input id="pac-input" type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror" />
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="hidden" name="lat" value="{{$setting->lat}}" id="lat">
                                    <input type="hidden" name="lng" value="{{$setting->lang}}" id="lng">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="map" class="mapClass"></div>
                            </div>
                        </div>
                        <div class="form-group text-right mt-3">
                            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                    <div class="mt-5 text-center">{{__("Already have an account?") }}
                        <a href="{{ url('pathologist_login') }}">{{__('login') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
                data-background="{{ url('assets/img/login.png') }}">
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

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
    <script src="{{ url('assets_admin/js/hospital_map.js') }}"></script>
@endsection

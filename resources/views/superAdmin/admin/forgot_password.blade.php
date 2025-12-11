@extends('layout.mainlayout_admin',['activePage' => 'login'])

@section('title',__('Forgot Password'))

@section('content')
<section class="section">
    <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
            <div class="p-4 m-3">
                @if (session('status'))
                @include('superAdmin.auth.status',[
                'status' => session('status')])
                @endif
                @php
                $app_logo = App\Models\Setting::first();
                @endphp
                @if(isset($app_logo->logo))
                <img src="{{ $app_logo->logo }}" alt="logo" width="180" class="mb-5 mt-2">
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
                <h6 class="p-1">{{__('Add Email Address To Get New Password')}}</h6>
                <form action="{{ url('send_forgot_password') }}" method="post" class="myform">
                    @csrf
                    <div class="form-group">
                        <input class="form-control @error('email') is-invalid @enderror" required name="email" value="{{ old('email') }}" type="email">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">{{__('Send Email')}}</button>
                    </div>
                </form>

                @if ($from == 'super admin')
                <div class="text-center mt-5">
                    <a href="{{ url('/login') }}">{{__('Remember Password?')}}</a>
                </div>
                @endif
                @if ($from =='doctor')
                <div class="text-center mt-5">
                    <a href="{{ url('doctor/doctor_login') }}">{{__('Remember Password?')}}</a>
                </div>
                @endif
                @if ($from =='pharmacy')
                <div class="text-center mt-5">
                    <a href="{{ url('pharmacy_login') }}">{{__('Remember Password?')}}</a>
                </div>
                @endif
                @if ($from =='lab')
                <div class="text-center mt-5">
                    <a href="{{ url('pathologist_login') }}">{{__('Remember Password?')}}</a>
                </div>
                @endif
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

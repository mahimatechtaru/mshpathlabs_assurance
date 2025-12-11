@extends('layout.mainlayout_admin',['activePage' => 'login'])

@section('title',__('Doctor Register'))

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
            <form action="{{ url('doctor/doctor_register') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">{{__('Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ old('name') }}" type="name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">{{__('Email') }}</label>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">{{__('Phone') }}</label>
                    <div class="d-flex @error('phone') is-invalid @enderror">
                        <select name="phone_code" class="phone_code_select2">
                            @foreach ($countries as $country)
                                <option value="+{{$country->phonecode}}" {{(
                                    env('DEFAULT_DIALING_CODE') == $country->phonecode) ? 'selected':''}}>+{{ $country->phonecode }}</option>
                            @endforeach
                        </select>
                        <input type="number" value="{{ old('phone') }}" name="phone" class="form-control">
                    </div>
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{__('Password') }}</label>
                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{__('Date of birth') }}</label>
                    <input type="text" class="form-control datePicker @error('dob') is-invalid @enderror" name="dob">
                    @error('dob')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{__('Gender') }}</label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="male">{{__('male')}}</option>
                        <option value="female">{{__('female')}}</option>
                        <option value="other">{{__('other')}}</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group text-right">
                    <span class="float-left">{{__("Already have an account?")}} <a href="{{ url('doctor/doctor_login') }}">{{__('Login')}}</a></span>
                    <button class="btn btn-primary btn-lg btn-icon icon-right" type="submit">{{__('Sign Up')}}</button>
                </div>
            </form>
            <div class="login-or">
                <span class="or-line"></span>
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

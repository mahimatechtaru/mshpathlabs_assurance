@extends('layout.mainlayout',['activePage' => 'signup'])

@section('css')
<link rel="stylesheet" href="{{ url('assets/css/intlTelInput.css') }}" />
<style>
    .signupDiv.active {
        border-color: var(--site_color);
    }

    .signupDiv.active div {
        border: var(--site_color);
    }

    .signupDiv.active label {
        color: black
    }

    .nav-tabs .nav-item .nav-link.active {
        border: 1px solid var(--site_color) !important;
        color: black !important;
    }

    .iti {
        display: block !important;
    }

    .hide {
        display: none;
    }

    /* .contentDisplay .active
    {
        display: block;
    } */
</style>
@endsection

@section('content')

<div class="xl:w-3/4 mx-auto">
    <div class="flex justify-between pt-20 pb-20 gap-10 lg:flex-row xxsm:flex-col xxsm:mx-5 xl:mx-0 2xl:mx-0">
        <div class="bg-slate-100 2xl:w-2/4 xxsm:w-full">
            <h1 class="font-fira-sans leading-10 font-medium text-3xl px-5 p-5 ml-5">{{__('Find the best doctor and medicine for you.')}}</h1>
            <div class="">
                <img src="{{asset('assets/image/doctor-nurses.png')}}" class="mt-20" alt="">
            </div>
        </div>

        <div class="2xl:w-2/4 xxsm:w-full">
            <h1 class="font-fira-sans leading-10 font-normal text-3xl">{{__('Welcome,')}}</h1>
            <h1 class="font-fira-sans leading-10 font-medium text-3xl">{{__('Create New Account!')}}</h1>
            <div class="pt-5 flex">
                @if (old('from'))
                @if (old('from') == 'doctor')
                @php
                $active = 'doctor';
                @endphp
                @else
                @php
                $active = 'patient';
                @endphp
                @endif
                @else
                @php
                $active = 'patient';
                @endphp
                @endif
                <div data-attr="doctor" class="signupDiv w-1/3 cursor-pointer py-1 ml-2 border border-[#D8D8D8] {{ $active == 'doctor' ? 'active' : '' }}">
                    <input {{ $active == 'doctor' ? 'checked' : '' }} id="bordered-radio-1" type="radio" value="doctor" name="signup_title" class="border-[#D8D8D8] cursor-pointer signup_title ml-2 text-blue-600">
                    <label for="bordered-radio-1" class="text-sm font-medium text-[#666666]">{{ __('Doctor') }}</label>
                </div>
                <div data-attr="patient" class="signupDiv w-1/3 cursor-pointer py-1 ml-2 border border-[#D8D8D8] {{ $active == 'patient' ? 'active' : '' }}">
                    <input {{ $active == 'patient' ? 'checked' : '' }} id="bordered-radio-2" type="radio" value="patient" name="signup_title" class="border-[#D8D8D8] cursor-pointer signup_title ml-2 text-blue-600">
                    <label for="bordered-radio-2" class="text-sm font-medium text-[#666666]">{{ __('Patient') }}</label>
                </div>
            </div>
            <div class="tab-content contentDisplay" id="tabs-tabContent">
                <div class="{{ $active == 'doctor' ?  'active' : 'hide' }} doctorDiv">
                    <form action="{{ url('doctorRegister') }}" method="post">
                        @csrf
                        <input type="hidden" name="from" value="doctor">
                        <div class="pt-3">
                            <label class="font-fira-sans text-black text-sm font-normal">{{__('Doctor Name')}}</label>
                            <input type="text" name="doc_name" value="{{ old('doc_name') }}" class="@error('doc_name') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter doctor name')}}">
                            @error('doc_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="email" class="font-fira-sans text-black text-sm font-normal">{{__('Email')}}</label>
                            <input type="email" name="doc_email" value="{{ old('doc_email') }}" class="@error('doc_email') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter email')}}">
                            @error('doc_email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="phone" class="font-fira-sans text-black text-sm font-normal">{{__('Phone Number')}}</label>
                            <input type="number" name="doc_phone" value="{{ old('doc_phone') }}" class="@error('doc_phone') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light doc_phone" placeholder="{{__('Enter Phone Number')}}">
                            <input type="hidden" name="phone_code" value={{ "+".env('DEFAULT_DIALING_CODE') }}>
                            @error('doc_phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="password" class="font-fira-sans text-black text-sm font-normal">{{__('Create Password')}}</label>
                            <input type="password" name="doc_password" class="@error('doc_password') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter password')}}">
                            @error('doc_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="doc_dob" class="font-fira-sans text-black text-sm font-normal">{{__('Birth Date')}}</label>
                            <div class="relative mb-3" data-te-datepicker-init data-te-input-wrapper-init data-te-format="yyyy-mm-dd">
                                <input name="doc_dob" value="{{ old('doc_dob') }}" placeholder="yyyy-mm-dd" class="@error('doc_dob') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20" data-te-datepicker-toggle-ref data-te-datepicker-toggle-button-ref />
                            </div>
                            @error('doc_dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <div class="flex items-center mb-5">
                                <label for="email" class="font-fira-sans text-black text-sm font-normal">{{__('Gender')}}</label>
                                <div class="ml-10 flex gap-10">
                                    <div class="form-check form-check-inline">
                                        <input checked class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="doc_gender" id="doc_gender_male" value="male">
                                        <label class="form-check-label inline-block text-gray-800  cursor-pointer" for="gender_male">{{ __('Male') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="doc_gender" id="doc_gender_female" value="female">
                                        <label class="form-check-label inline-block text-gray-800  cursor-pointer" for="gender_female">{{ __('Female') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-3">
                            <button type="submit" class="font-fira-sans text-white bg-primary w-full text-sm font-normal py-3">{{__('Submit')}}</button>
                            <h1 class="font-fira-sans font-medium text-sm leading-5 pt-4 text-center">{{__('Already have an account?')}}
                                <a href="{{url('patient-login')}}" class="text-primary text-normal">{{__('Login')}}</a>
                            </h1>
                        </div>
                    </form>
                </div>
                <div class="{{ $active == 'patient' ?  'active' : 'hide' }} patientDiv">
                    <form action="{{ url('signUp') }}" method="post">
                        <input type="hidden" name="from" value="patient">
                        @csrf
                        <div class="pt-3">
                            <label class="font-fira-sans text-black text-sm font-normal">{{__('Patient Name')}}</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter patient name')}}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="email" class="font-fira-sans text-black text-sm font-normal">{{__('Email')}}</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror  w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter email')}}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="phone" class="font-fira-sans text-black text-sm font-normal">{{__('Phone Number')}}</label>
                            <input type="number" name="phone" value="{{ old('phone') }}" class="@error('phone') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light phone" placeholder="{{__('Enter Phone Number')}}">
                            <input type="hidden" name="phone_code" value="+880">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="password" class="font-fira-sans text-black text-sm font-normal">{{__('Create Password')}}</label>
                            <input type="password" name="password" class="@error('password') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter password')}}">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="dob" class="font-fira-sans text-black text-sm font-normal">{{__('Birth Date')}}</label>
                            <div class="relative mb-3" data-te-datepicker-init data-te-input-wrapper-init data-te-format="yyyy-mm-dd">
                                <input name="dob" value="{{ old('dob') }}" placeholder="yyyy-mm-dd" class="@error('dob') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20" data-te-datepicker-toggle-ref data-te-datepicker-toggle-button-ref />
                            </div>
                            @error('dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <div class="flex items-center mb-5">
                                <label for="email" class="font-fira-sans text-black text-sm font-normal">{{__('Gender')}}</label>
                                <div class="ml-10 flex gap-10">
                                    <div class="form-check form-check-inline">
                                        <input checked class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="gender" id="gender_male" value="male">
                                        <label class="form-check-label inline-block text-gray-800  cursor-pointer" for="gender_male">{{ __('Male') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="gender" id="gender_female" value="female">
                                        <label class="form-check-label inline-block text-gray-800  cursor-pointer" for="gender_female">{{ __('Female') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-3">
                            <button type="submit" class="font-fira-sans text-white bg-primary w-full text-sm font-normal py-3">{{__('Submit')}}</button>
                            <h1 class="font-fira-sans font-medium text-sm leading-5 pt-4 text-center">{{__('Already have an account?')}}
                                <a href="{{url('patient-login')}}" class="text-primary text-normal">{{__('Login')}}</a>
                            </h1>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/js/intlTelInput.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.signupDiv').click(function() {
            $('.signupDiv').removeClass('active');
            $(this).addClass('active');
            $(this).children('input[type=radio]').prop('checked', true);
            var radioVal = $(this).children('input[type=radio]').val();
            $('.invalid-feedback').text('');
            if (radioVal == 'doctor') {
                $('.doctorDiv').show();
                $('.patientDiv').hide();
            }
            if (radioVal == 'patient') {
                $('.doctorDiv').hide();
                $('.patientDiv').show();
            }
        });
    });
    const phoneInputField = document.querySelector(".phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        preferredCountries: ["us", "co", "in", "de"],
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
    });
    phoneInputField.addEventListener("countrychange", function() {
        var phone_code = $('.phone').find('.iti__selected-dial-code').text();
        $('input[name=phone_code]').val('+' + phoneInput.getSelectedCountryData().dialCode);
    });

    const DocphoneInputField = document.querySelector(".doc_phone");
    const docphoneInput = window.intlTelInput(DocphoneInputField, {
        preferredCountries: ["us", "co", "in", "de"],
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
    });
    DocphoneInputField.addEventListener("countrychange", function() {
        $('input[name=phone_code]').val('+' + docphoneInput.getSelectedCountryData().dialCode);
    });
</script>
@endsection

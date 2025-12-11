@extends('layout.mainlayout',['activePage' => 'user'])

@section('css')
<link rel="stylesheet" href="{{ url('assets/css/intlTelInput.css') }}" />
<style>
    .sidebar li.active {
        background: linear-gradient(45deg, #00000000 50%, #f4f2ff);
        border-left: 2px solid var(--site_color);
    }

    .iti {
        display: block !important;
    }
</style>
@endsection

@section('content')
<div class="xl:w-3/4 mx-auto">
    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0 pt-10">
        <div class="flex h-full mb-20 xxsm:flex-col sm:flex-col xmd:flex-row xmd:space-x-5">
            <div class="2xl:w-1/5 1xl:w-1/5 xl:w-1/4 xlg:w-80 lg:w-72 xxmd:w-72 !xmd:w-72 md:w-72 h-auto">
                @include('website.user.userSidebar',['active' => 'profileSetting'])
            </div>
            <div class="w-full md:w-full xxmd:w-full xmd:w-80 lg:w-2/3 xlg:w-2/3 1xl:w-full 2xl:w-full sm:ml-0 xxsm:ml-0 shadow-lg overflow-hidden p-5 mt-10 2xl:mt-0 xmd:mt-0">
                <form action="{{ url('update_user_profile') }}" method="post" class="h-100" enctype="multipart/form-data">
                    @csrf
                    <div class="change-avtar">
                        <div class="avatar-upload relative">
                            <div class="avatar-edit absolute">
                                <input type='file' name="image" id="image" class="d-none" accept=".png, .jpg, .jpeg" />
                                <label for="image" class="" data-bs-toggle="tooltip" data-bs-placement="right" title="Select new profile pic"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{ 'images/upload/'.auth()->user()->image }});"></div>
                            </div>
                            <div class="mt-2">
                                <p class="text-center patient-image">{{ __('Patient Image') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex xxsm:flex-col sm:flex-row justify-center w-full">
                        <div class="mb-3 sm:w-1/2 xxsm:w-full">
                            <label for="name" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Name')
                            }}</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control block w-full font-fira-sans px-3 py-1.5 text-base font-normal text-gray  bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="name" placeholder="{{ __('Name') }}" />
                        </div>
                        <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                            <label for="email" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Email')
                            }}</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray  bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="email" placeholder="{{ __('Email') }}" />
                        </div>

                    </div>
                    <div class="flex xxsm:flex-col sm:flex-row justify-center w-full">
                        <div class="mb-3 sm:w-1/2 xxsm:w-full">
                            <label for="phoneNumber" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Phone Number') }}</label>
                            <input type="text" name="phone" required value="{{ auth()->user()->phone_code }}&nbsp;{{ auth()->user()->phone }}" class="phone font-fira-sans form-control block w-full px-3 py-1.5 text-base font-normal text-gray  bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="phoneNumber" placeholder="{{ __('Phone number') }}" />
                            <input type="hidden" name="phone_code" value={{ "+".env('DEFAULT_DIALING_CODE') }}>
                        </div>
                        <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                            <label for="language" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Language')}}</label>
                            <div class="flex justify-center">
                                <div class="mb-3 w-full">
                                    <select name="language" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray  bg-clip-padding bg-no-repeat border
                                    border-solid border-gray-light rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" aria-label="Default select example">
                                        @foreach ($languages as $language)
                                        <option class="font-fira-sans" value="{{ $language->name }}" {{ $language->name == auth()->user()->language
                                        ? 'selected' : '' }}>{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex xxsm:flex-col sm:flex-row justify-center w-full">
                        <div class="mb-3 sm:w-1/2 xxsm:w-full">
                            <label for="dob" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Date of birth')}}</label>
                            <div class="relative mb-3" data-te-datepicker-init data-te-input-wrapper-init data-te-format="yyyy-mm-dd">
                                <input name="dob" value="{{ auth()->user()->dob }}" placeholder="yyyy-mm-dd" class="@error('dob') is-invalid @enderror font-fira-sans form-control block w-full px-3 py-1.5 text-base font-normal text-gray  bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray focus:outline-none active" data-te-datepicker-toggle-ref data-te-datepicker-toggle-button-ref />
                            </div>
                            @error('dob')
                            <div class="invalid-feedback font-fira-sans">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                            <label for="language" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Gender')
                            }}</label>
                            <div class="flex justify-center">
                                <div class="mb-3 w-full">
                                    <select name="gender" class="form-select font-fira-sans appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray  bg-clip-padding bg-no-repeat
                                     border border-solid border-gray-light rounded transition ease-in-out m-0 focus:text-gray focus:outline-none
                                     " aria-label="Default select example">
                                        <option {{ auth()->user()->gender == 'male' ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                        <option {{ auth()->user()->gender == 'female' ? 'selected' : '' }} value="female">{{__('Female') }}</option>
                                        <option {{ auth()->user()->gender == 'other' ? 'selected' : '' }} value="other">{{ __('Other') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between w-full xxsm:flex-col msm:flex-row">
                        <div class="w-full mb-4">
                            <a class="px-6 py-3 border font-fira-sans border-red text-white bg-red rounded-md font-medium text-xs leading-tight uppercase focus:outline-none
                            focus:ring-0 transition duration-150 ease-in-out" href="javascript:void(0);" onclick="delete_account()">
                                {{__("Delete Account")}}
                            </a>
                        </div>
                        <div class="w-full mb-4 flex msm:justify-end xxsm:justify-start ">
                            <button class="px-6 py-3 font-fira-sans border border-primary text-white bg-primary rounded-md font-medium text-xs leading-tight uppercase focus:outline-none focus:ring-0 transition duration-150 ease-in-out" type="submit" id="button-addon3">
                                {{__("Update")}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="{{ url('assets/js/intlTelInput.min.js') }}"></script>
<script>
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

    $(document).ready(function() {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var type = $('#imagePreview').attr('data-id');
                    var fileName = document.getElementById("image").value;
                    var idxDot = fileName.lastIndexOf(".") + 1;
                    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                    if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    } else {
                        $('input[type=file]').val('');
                        alert("Only jpg/jpeg and png files are allowed!");
                        if (type == 'add') {
                            $('#imagePreview').css('background-image', 'url()');
                            $('#imagePreview').hide();
                            $('#imagePreview').fadeIn(650);
                        }
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image").change(function() {
            readURL(this);
        });
    });
</script>
@endsection

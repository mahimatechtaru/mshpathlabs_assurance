@extends('layout.mainlayout',['activePage' => 'labs'])

@section('css')

<link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.5/dist/flowbite.min.css" />
<style>
    .custom-error {
        font-size: 12px;
        color: #d20f0f;
        font-weight: bold;
    }

    .activeAddress {
        border-color: #5da1ff !important;
        /* background-color: #f4fbfd; */
    }

    .timeslots svg {
        display: none !important
    }

    .activeTimeslots svg {
        display: inline !important
    }

    svg {
        display: inline !important;
    }

    .datepicker-footer {
        position: inherit !important;
    }

    .timeslots {
        width: 84px !important;
        height: 33px !important;
        font-size: 14px !important;
    }

    .activeTimeslots {
        border-color: var(--site_color) !important;
        background-color: var(--site_color) !important;
        color: white !important;
    }

    #offer-code {
        --tw-ring-shadow: 0px;
    }

    .datepicker-header {
        height: 45px;
        background-color: transparent;
    }

    .datepicker-cell.focused {
        border-radius: 50%;
        border-radius: 50%;
        height: 50px;
        width: 50px;
        line-height: 50px;
    }

    .datepicker-cell {
        height: 50px;
        width: 50px;
        line-height: 50px !important;
    }

    .datepicker-cell:hover {
        border-radius: 50%;
    }

    #datepickerId .datepicker-picker.shadow-lg {
        box-shadow: none;
    }

    .datepicker.datepicker-inline.active.block {
        display: inline !important;
    }

    #datepickerId {
        text-align: center;
    }

    .datepicker-view {
        display: flow-root !important;
    }

    .datepicker-grid {
        width: 100% !important;
        margin-left: auto;
    }

    .select2-container--default .select2-selection--single {
        border-radius: 0px;
        height: 35px !important;
        /* height: 100% !important; */
    }

    .select2-container--default .select2-selection--multiple {
        height: 35px !important;
        border-radius: 0px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #2563eb;
        border: 1px solid #2563eb;
    }

    #file-upload-button {
        background: red !important;
    }

    .paymentDiv {
        cursor: pointer;
    }

    .activePayment {
        color: #2563eb !important;
        background: #f4fbfd !important;
    }
</style>
@endsection

@section('content')
{{-- Report Test --}}
<div class="xl:w-3/4 mx-auto pt-10 pb-10">
    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0">
        <h1 class="font-fira-sans font-medium text-4xl text-left leading-10 pb-5">{{__('Report Test')}}</h1>
        <form id="testForm" action="main">
            <input type="hidden" name="lab_id" value="{{ $lab->id }}">
            <input type="hidden" name="currency" value="{{ $setting->currency_code }}">
            <input type="hidden" name="company_name" value="{{ $setting->business_name }}">
            <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
            <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
            <input type="hidden" name="prescription_required" value="0">
            <input type="hidden" name="payment_type" value="COD">
            <input type="hidden" name="amount" step="any">
            <input type="hidden" name="payment_token">
            <input type="hidden" name="payment_status" value="0">
            <div class="">
                <div class="Appointment-detail ">
                    <div class="Appointment-detail ">
                        <div class="progress-container">
                            <div class="progress" id="progress"></div>
                            <div class="circle progress_active">1</div>
                            <div class="circle">2</div>
                            <div class="circle">3</div>
                        </div>
                        <input type="hidden" name="lab_id" value="{{ $lab->id }}">
                        <div id="step1" class="block border border-white-light p-5">
                            {{-- <form id="form1" action="a"> --}}
                            <h1 class="font-fira-sans leading-6 text-xl font-medium py-6">{{__('Patient Details')}}</h1>
                            <div class="flex justify-between 2xl:flex-row 2xl:space-x-5 xxsm:flex-col lg:flex-row lg:space-x-5">
                                <div class="flex flex-col pt-5 w-1/3 msm:w-full xsm:w-full xxsm:w-full">
                                    <label class="text-base font-normal font-fira-sans leading-5">{{__('Patient Name')}}</label>
                                    <div class="relative pt-2">
                                        <input type="text" name="patient_name" class="@error('patient_name') is-invalid @enderror block p-2 w-full z-20 text-sm border font-normal font-fira-sans leading-5 border-white-light" placeholder="{{__('Enter patient name')}}" required>
                                        <span class="invalid-div text-danger"><span class="patient_name"></span></span>
                                    </div>
                                </div>
                                <div class="flex flex-col pt-5 w-1/3 msm:w-full xsm:w-full xxsm:w-full">
                                    <label class="text-base font-normal font-fira-sans leading-5 pb-2">{{__('Patient Age')}}</label>
                                    <input type="number" name="age" class="@error('age') is-invalid @enderror block p-2 w-full z-20 text-sm border font-normal font-fira-sans leading-5 border-white-light" placeholder="{{__('Enter patient age')}}" required>
                                    <span class="invalid-div text-danger"><span class="age"></span></span>
                                </div>
                                <div class="flex flex-col pt-5 w-1/3 msm:w-full xsm:w-full xxsm:w-full">
                                    <label class="text-base font-normal font-fira-sans leading-5 pb-2">{{__('Phone Number')}}</label>
                                    <input type="number" name="phone_no" class="@error('phone_no') is-invalid @enderror block p-2 w-full z-20 text-sm border font-normal font-fira-sans leading-5 border-white-light" placeholder="{{__('Enter Phone Number')}}" required>
                                    <span class="invalid-div text-danger"><span class="phone_no"></span></span>
                                </div>
                            </div>
                            <div class="justify-between flex 2xl:flex-row 2xl:space-x-5 2xl:space-y-0 xl:flex-row xl:space-x-5 xl:space-y-0 xlg:flex-row xlg:space-x-5 xlg:space-y-0 lg:flex-row lg:space-x-5 lg:space-y-0
                                xmd:flex-row xmd:space-x-5 xmd:space-y-0 md:flex-row  md:space-x-5 md:space-y-0 pt-2 space-x-5 msm:flex-col msm:space-y-5 msm:space-x-0 xsm:flex-col xsm:space-x-0 xsm:space-y-5 xxsm:flex-col xxsm:space-x-0 xxsm:space-y-5">
                                <div class="flex flex-col pt-5 w-full">
                                    <label class="text-base font-normal font-fira-sans leading-5">{{__('Patient Gender')}}</label>
                                    <div class="flex justify-center">
                                        <div class="mb-3 w-full">
                                            <select name="gender" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding bg-no-repeat border
                                                 border-white-light transition ease-in-out m-0 fo focus:bg-white focus:border-primary focus:outline-none" aria-label="Default select example">
                                                <option value="male">{{ __('Male') }}</option>
                                                <option value="female">{{ __('Female') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h1 class="font-fira-sans leading-6 text-xl font-medium py-6">{{__('Report Details')}}</h1>
                            <div class="flex">
                                <div class="form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-white-light bg-white checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="category" value="pathology" id="pathology" checked>
                                    <label class="form-check-label inline-block text-gray-800" for="pathology">
                                        {{ __('Pathology') }}
                                    </label>
                                </div>
                                <div class="ml-5 form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-white-light bg-white checked:bg-primary checked:border-primary focus:outline-none
                                        transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="category" value="radiology" id="radiology">
                                    <label class="form-check-label inline-block text-gray-800" for="radiology">
                                        {{ __('Radiology') }}
                                    </label>
                                </div>
                            </div>
                            <div class="pathology_department justify-between flex 2xl:flex-row 2xl:space-x-5 xxsm:flex-col md:flex-row md:space-x-5">
                                <div class="flex flex-col pt-5 msm:w-full xsm:w-full xxsm:w-full">
                                    <label class="text-base font-normal font-fira-sans leading-5 mb-4">{{__('Test type')}}</label>
                                    <select id="pathology_id" multiple name="pathology_id[]" class="select2 mt-2 border border-white-light text-gray-900 text-sm focus:outline-none block w-full p-2.5">
                                    </select>
                                </div>
                            </div>
                            <div class="radiology_department hidden justify-between flex 2xl:flex-row 2xl:space-x-5 xxsm:flex-col md:flex-row md:space-x-5">
                                <div class="flex flex-col pt-5 msm:w-full xsm:w-full xxsm:w-full">
                                    <label class="text-base font-normal font-fira-sans leading-5 mb-4">{{__('Screening For')}}</label>
                                    <select id="radiology_id" multiple name="radiology_id[]" class="select2 mt-2 border border-white-light text-gray-900 text-sm focus:outline-none block w-full p-2.5">
                                    </select>
                                </div>
                            </div>
                            <div class="hidden pathology_single_details">
                            </div>
                            <div class="hidden radiology_single_details">
                            </div>
                            <div class="hidden presciption_required border border-white-light p-2 m-2">
                                <input type="hidden" name="checkExists">
                                <div class="flex 2xl:flex-row 2xl:space-x-5 2xl:space-y-0 xl:flex-row xl:space-x-5 xl:space-y-0 xlg:flex-row xlg:space-x-5 xlg:space-y-0
                                     lg:flex-row lg:space-x-5 lg:space-y-0 xmd:flex-row xmd:space-x-5 xmd:space-y-0 md:flex-row  md:space-x-5 md:space-y-0 pt-2 space-x-5
                                     msm:flex-col msm:space-y-5 msm:space-x-0 xsm:flex-col xsm:space-x-0 xsm:space-y-5 xxsm:flex-col xxsm:space-x-0 xxsm:space-y-5">
                                    <div class="flex flex-col w-1/2 msm:w-full xsm:w-full xxsm:w-full">
                                        <label class="text-base font-normal font-fira-sans leading-5 mb-4">{{__('Select Doctor')}}</label>
                                        <select id="doctor_id" name="doctor_id" class=" @error('doctor_id') is-invalid @enderror select2 mt-2 border border-white-light text-gray-900 text-sm focus:outline-none block w-full p-2.5">
                                            <option value="">{{ __('Select doctor') }}</option>
                                            @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-div text-danger"><span class="doctor_id"></span></span>
                                    </div>
                                    <div class="flex justify-center w-1/2">
                                        <div class="mb-3 w-full">
                                            <label class="block mb-4 text-sm font-normal text-gray-900 font-fira-sans" for="small_size">{{ __('Upload Test Prescription') }}</label>
                                            <input type="file" name="prescription" class="block w-full mb-5 text-xs text-gray border border-white-light cursor-pointer bg-gray dark:text-gray-light
                                                focus:outline-none dark:bg-gray dark:border-gray dark:placeholder-gray" id="small_size">
                                            <span class="invalid-div text-danger"><span class="prescription"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--
                        </form> --}}
                        </div>
                        <div id="step2" class="hidden">
                            {{-- <form id="form2" action="b"> --}}
                            <div class="flex 2xl:flex-row xxsm:flex-col lg:flex-row">
                                <div class="2xl:w-6/12 xl:w-96 border xxsm:w-full">
                                    @php
                                    $date = Carbon\Carbon::now(env('timezone'));
                                    @endphp
                                    @if (Session::get('locale') ==='Arabic')
                                        <div id="datepickerId" onclick="getTime()" data-date="{{ $date->format('Y-m-d') }}" datepicker-format="dd/mm/yyyy" class="2xl:w-full rtl"></div>
                                    @elseif(Session::get('locale') ==='English')
                                        <div id="datepickerId" onclick="getTime()" data-date="{{ $date->format('Y-m-d') }}" datepicker-format="dd/mm/yyyy" class="2xl:w-full rtl"></div>
                                    @endif
                                </div>
                                <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                                <div class="2xl:w-2/5 xl:w-3/4 border p-10 !xxsm:w-full">
                                    <div class="">
                                        <h4 class="text-base font-normal font-fira-sans">
                                            <span class="currentDate">{{ $date->format('d M') }}</span>{{__(',Avalibility')}}
                                        </h4>
                                        <div class="flex flex-wrap timeSlotRow">
                                            @if (count($timeslots)>0)
                                            @foreach ($timeslots as $timeslot)
                                            @if ($loop->iteration == 1)
                                            <input type="hidden" name="time" value="{{ $timeslot['start_time'] }}">
                                            @endif
                                            <a href="javascript:void(0)" onclick="thisTime({{ $loop->iteration }})" class="time timing{{ $loop->iteration }} border border-gray text-center py-1 2xl:px-2 sm:px-2  msm:px-2 font-fira-sans font-normal xl:px-1 xlg:px-1 text-black m-1 timeslots {{ $loop->first ? 'activeTimeslots' : '' }}">
                                                <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 11.75C4.60761 11.75 3.27226 11.1969 2.28769 10.2123C1.30312 9.22774 0.75 7.89239 0.75 6.5C0.75 5.10761 1.30312 3.77226 2.28769 2.78769C3.27226 1.80312 4.60761 1.25 6 1.25C7.39239 1.25 8.72774 1.80312 9.71231 2.78769C10.6969 3.77226 11.25 5.10761 11.25 6.5C11.25 7.89239 10.6969 9.22774 9.71231 10.2123C8.72774 11.1969 7.39239 11.75 6 11.75ZM6 12.5C7.5913 12.5 9.11742 11.8679 10.2426 10.7426C11.3679 9.61742 12 8.0913 12 6.5C12 4.9087 11.3679 3.38258 10.2426 2.25736C9.11742 1.13214 7.5913 0.5 6 0.5C4.4087 0.5 2.88258 1.13214 1.75736 2.25736C0.632141 3.38258 0 4.9087 0 6.5C0 8.0913 0.632141 9.61742 1.75736 10.7426C2.88258 11.8679 4.4087 12.5 6 12.5V12.5Z" fill="white" />
                                                    <path d="M8.22727 4.22747C8.22192 4.23264 8.21691 4.23816 8.21227 4.24397L5.60752 7.56272L4.03777 5.99222C3.93113 5.89286 3.7901 5.83876 3.64437 5.84134C3.49865 5.84391 3.35961 5.90294 3.25655 6.006C3.15349 6.10906 3.09446 6.2481 3.09188 6.39382C3.08931 6.53955 3.14341 6.68059 3.24277 6.78722L5.22727 8.77247C5.28073 8.82583 5.34439 8.86788 5.41445 8.89611C5.48452 8.92433 5.55955 8.93816 5.63507 8.93676C5.7106 8.93536 5.78507 8.91876 5.85404 8.88796C5.92301 8.85716 5.98507 8.81278 6.03652 8.75747L9.03052 5.01497C9.13246 4.90796 9.1882 4.76514 9.18568 4.61737C9.18317 4.4696 9.12259 4.32875 9.01706 4.22529C8.91152 4.12182 8.76951 4.06405 8.62171 4.06446C8.47392 4.06486 8.33223 4.12342 8.22727 4.22747Z" fill="white" />
                                                </svg>
                                                <span class="ml-1">{{ $timeslot['start_time'] }}</span>
                                            </a>
                                            @endforeach
                                            @else
                                            <strong class="text-red-600 text-center w-100 mt-4">{{__('At this Date Laboratory is not available please change the date.')}}</strong>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--
                        </form> --}}
                        </div>
                        <div id="step3" class="hidden">
                            {{-- <div class="flex justify-between border border-white-light"> --}}
                            <div class="flex w-full 2xl:mx-0 xl:mx-0 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row xsm:flex-col xxsm:flex-col">
                                <div class="border border-white-light p-5 2xl:w-3/4 xl:w-3/4 xlg:w-3/4 lg:w-3/4 xmd:w-2/4 md:w-3/4 sm:w-3/4 xsm:w-full xxsm:w-full">
                                    <h2 class="font-fira-sans font-medium mt-4 text-2xl">{{ __('Payment Method') }}</h2>
                                    <div class="mt-5 flex justify-between 2xl:flex-row 2xl:space-y-0 2xl:space-x-5 xxsm:flex-col xxsm:space-y-5 lg:flex-row lg:space-y-0 !xl:space-x-[2px] mb-5">
                                        @if ($setting->cod)
                                        <div class="border border-1 font-fira-sans paymentDiv text-center activePayment 2xl:w-44 h-28 xxsm:w-full p-6" data-attribute="cod">
                                            <img class="mx-auto w-20" src="{{ url('assets/image/cod.png') }}" alt="">
                                            <p class="mt-3">{{ __('COD') }}</p>
                                        </div>
                                        @endif
                                        @if ($setting->paypal)
                                        <div class="border border-1 font-fira-sans paymentDiv text-center 2xl:w-44 h-28 xxsm:w-full p-6" data-attribute="paypal">
                                            <img class="mx-auto w-6" src="{{ url('assets/image/logos_paypal.png') }}" alt="">
                                            <p class="mt-3">{{ __('Paypal') }}</p>
                                        </div>
                                        @endif
                                        @if ($setting->stripe)
                                        <div class="border border-1 font-fira-sans paymentDiv text-center 2xl:w-44 h-28 xxsm:w-full p-6" data-attribute="stripe">
                                            <img class="mx-auto w-12" src="{{ url('assets/image/logos_stripe.png') }}" alt="">
                                            <p class="mt-3">{{ __('Stripe') }}</p>
                                        </div>
                                        @endif
                                        @if ($setting->paystack)
                                        <div class="border border-1 font-fira-sans paymentDiv text-center 2xl:w-44 h-28 xxsm:w-full p-6" data-attribute="paystack">
                                            <img class="mx-auto w-28" src="{{ url('assets/image/paystack.png') }}" alt="">
                                            <p class="mt-3">{{ __('Paystack') }}</p>
                                        </div>
                                        @endif
                                        @if ($setting->flutterwave)
                                        <div class="border border-1 font-fira-sans paymentDiv text-center 2xl:w-44 h-28 xxsm:w-full p-6" data-attribute="flutterwave">
                                            <img class="mx-auto w-28" src="{{ url('assets/image/flutterwave.png') }}" alt="">
                                            <p class="mt-3">{{ __('Flutterwave') }}</p>
                                        </div>
                                        @endif
                                        @if ($setting->razor)
                                        <div class="border border-1 font-fira-sans paymentDiv text-center 2xl:w-44 h-28 xxsm:w-full p-6" data-attribute="razorpay">
                                            <img class="mx-auto w-7" src="{{ url('assets/image/razorpay.png') }}" alt="">
                                            <p class="mt-3">{{ __('Razorpay') }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="codDiv text-center">
                                        <input type="button" class="font-fira-sans text-white bg-blue-600 p-3 text-sm font-normal py-3 cursor-pointer" onclick="report_book()" value="{{__('Pay Cash on Delivery')}}">
                                    </div>
                                    <div class="paypalDiv hidden">

                                    </div>
                                    <div class="stripDiv hidden">
                                        <div class="bg-red-100 stripe_alert hidden rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full" role="alert">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z">
                                                </path>
                                            </svg>
                                            <div class="stripeText"></div>
                                        </div>
                                        <input type="hidden" name="stripe_publish_key" value="{{$setting->stripe_public_key}}">
                                        <form role="form" method="post" class="require-validation customform" data-cc-on-file="false" id="stripe-payment-form">
                                            @csrf
                                            <div class="row p-4">
                                                <div class="form-group">
                                                    <label class="font-fira-sans font-medium text-bs">{{__('Email')}}</label>
                                                    <input type="email" class="mt-3 font-fira-sans required block p-2 w-full z-20 text-sm border font-normal leading-5 border-white-light" title="Enter Your Email" name="email" required />
                                                </div>
                                                <div class="mt-3">
                                                    <label class="font-fira-sans font-medium text-bs">{{__('Card Information')}}</label>
                                                    <input type="text" class="card-number font-fira-sans mt-3 required block p-2 w-full z-20 text-sm border font-normal leading-5 border-white-light" title="please input only number." pattern="[0-9]{16}" name="card-number" placeholder="1234 1234 1234 1234" title="Card Number" required />
                                                </div>
                                                <div class="flex" class="mt-1">
                                                    <div class="w-1/2">
                                                        <input type="text" class="mt-3 mr-1 font-fira-sans expiry-date required block p-2 w-full z-20 text-sm border font-normal leading-5 border-white-light" name="expiry-date" title="Expiration date" title="please Enter data in MM/YY format." pattern="(0[1-9]|10|11|12)/[0-9]{2}$" placeholder="MM/YY" required />
                                                        <input type="hidden" class="card-expiry-month required form-control" name="card-expiry-month" />
                                                        <input type="hidden" class="card-expiry-year required form-control" name="card-expiry-year" />
                                                    </div>
                                                    <div class="w-1/2">
                                                        <input type="text" class="card-cvc font-fira-sans mt-3 ml-1 required block p-2 w-full z-20 text-sm border font-normal leading-5 border-white-light" title="please input only number." pattern="[0-9]{3}" name="card-cvc" placeholder="CVC" title="CVC" required />
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="form-group">
                                                        <label class="font-fira-sans font-medium text-bs">{{__('Name on card')}}</label>
                                                        <input type="text" class="mt-3 font-fira-sans required block p-2 w-full z-20 text-sm border font-normal leading-5 border-white-light" name="name" title="Name on Card" required />
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="form-group text-center">
                                                        <input type="button" class="btn-submit font-fira-sans text-white !bg-primary w-full text-sm font-normal py-3 cursor-pointer" value="{{ __('Pay with stripe') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="paystackDiv hidden mt-5">
                                        <form id="paymentForm">
                                            <input type="hidden" id="paystack-public-key" value="{{ $setting->paystack_public_key }}">
                                            <input type="hidden" id="email-address" value="{{ auth()->user()->email }}" required />
                                            <div class="form-submit text-center">
                                                {{-- <div class="row"> --}}
                                                {{-- <div class="col-md-12 text-center"> --}}
                                                <input type="button" onclick="payStack()" class="font-fira-sans text-white !bg-primary p-3 text-sm font-normal py-3 cursor-pointer" onclick="payWithPaystack()" value="{{__('Pay with paystack')}}">
                                                {{--
                                                </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                        </form>
                                    </div>
                                    <div class="flutterwaveDiv hidden">
                                        <form>
                                            <input type="hidden" name="flutterwave_key" value="{{ $setting->flutterwave_key }}">
                                            <div class="w-full px-4 flex gap-3 items-center mt-5 rounded-md h-auto justify-center">
                                                {{-- <div class="row">
                                                <div class="col-md-12 text-center"> --}}
                                                <input type="button" onclick="makePayment(event)" class="font-fira-sans text-white !bg-primary p-3 text-sm font-normal py-3 cursor-pointer" value="{{__('Pay With Flutterwave')}}">
                                                {{--
                                                </div>
                                            </div> --}}
                                            </div>
                                        </form>
                                    </div>
                                    <div class="razorpayDiv text-center mt-5 hidden">
                                        <input type="hidden" id="RAZORPAY_KEY" value="{{ $setting->razor_key }}">
                                        {{-- <div class="row">
                                        <div class="col-md-12 text-center"> --}}
                                        <input type="button" id="paybtn" onclick="RazorPayPayment()" value="{{__('Pay with Razorpay')}}" class="font-fira-sans text-white !bg-primary p-3 text-sm font-normal py-3 cursor-pointer">
                                        {{--
                                        </div>
                                    </div> --}}
                                    </div>
                                </div>
                                <div class="border !border-l-0 !border-t-0 border-white-light 2xl:w-1/4 xl:w-1/4 xlg:w-1/4 lg:w-1/4 xmd:w-3/4 md:w-full sm:w-full msm:w-full xsm:w-full xxsm:w-full">
                                    <div class="docDisplay">
                                        <div class="hidden p-10">
                                            <img class="doctorImg 2xl:w-28 2xl:h-28 xlg:h-20 xlg:w-24 xl:h-24 xl:w-24 lg:h-20 lg:w-20 md:h-10 md:w-10 sm:h-10 sm:w-10 xsm:h-10 xsm:w-10 msm:h-10 msm:w-10 xxsm:h-10 xxsm:w-10 border border-blue rounded-full p-0.5 m-auto" src="" alt="" />
                                            <h5 class="doctorName font-fira-sans font-normal text-lg leading-6 text-black text-center md:text-md pt-5">
                                            </h5>
                                            <p class="doctorSpecialist font-normal leading-4 text-sm text-primary text-center font-fira-sans md:text-md py-2">
                                                {{__('Viralogist')}}
                                            </p>
                                            <p class="doctorReviews font-normal leading-4 text-sm text-gray text-center md:text-md">
                                            </p>
                                        </div>
                                        <div class="border-t border-white-light p-8">
                                            <div>
                                                <h5 class="font-fira-sans font-medium text-1xl text-left hospitalName"></h5>
                                            </div>
                                            <div class="flex mt-1 items-center">
                                                <i class="fa-solid fa-location-dot mr-3"></i>
                                                <p class="hospitalAddress"></p>
                                            </div>
                                            <div class="mt-4 text-2xl font-medium text-primary">
                                                <span class="text-bs text-primary">{{ $setting->currency_symbol }}</span>
                                                <span class="text-bs text-primary amount"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noteDisplay border border-white-light p-10">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Appointment-detail flex justify-between mt-10 mb-3">
                    <button type="button" class="border border-primary text-white !bg-primary text-center text-base font-normal font-fira-sans w-32 h-11" id="prev" disabled>{{ __('Previous') }}</button>

                    <button type="button" class="text-white !bg-primary text-center text-base font-normal font-fira-sans w-32 h-11" id="next">{{ __('Next')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/js/report.js') }}"></script>
<script src="https://unpkg.com/flowbite@1.5.5/dist/datepicker.js"></script>
<script src="https://unpkg.com/flowbite-datepicker@1.2.2/dist/js/datepicker-full.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@if(App\Models\Setting::first()->paystack_public_key)
<script src="https://js.paystack.co/v2/inline.js"></script>
@endif
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="{{ url('payment/razorpay.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

@if ($setting->paypal)
<script src="https://www.paypal.com/sdk/js?client-id={{ App\Models\Setting::first()->paypal_client_id }}&currency={{ App\Models\Setting::first()->currency_code }}" data-namespace="paypal_sdk"></script>
@endif
<script src="{{ url('payment/stripe.js')}}"></script>
<script>
    var a = '';
    const datepickerEl = document.getElementById('datepickerId');
    a = new Datepicker(datepickerEl, {
        format: 'yyyy-mm-dd',
        minDate: '{{ $date->format("Y-m-d") }}',
        todayHighlight: true,
        prevArrow: '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.68771 1.5649e-08L8 1.37357L2.62459 7L8 12.6264L6.68771 14L8.34742e-08 7L6.68771 1.5649e-08Z" fill="#000"/></svg>',
        nextArrow: '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.31229 14L-6.00408e-08 12.6264L5.37541 7L-5.51919e-07 1.37357L1.31229 -5.73622e-08L8 7L1.31229 14Z" fill="#000"/></svg>',
    });
</script>

@endsection

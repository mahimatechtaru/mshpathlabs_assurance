@extends('layout.mainlayout',['activePage' => 'doctors'])

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
        background-color: #f4fbfd;
    }

    .activeTimeslots {
        border-color: var(--site_color) !important;
        background-color: var(--site_color) !important;
        color: white !important;
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
    }

    .paymentDiv {
        /* width: 148px !important; */
        height: 87px !important;
        /* padding: 1rem !important; */
        cursor: pointer;
    }

    .activePayment {
        color: #2563eb !important;
        background: #f4fbfd !important;
    }

    .mapClass {
        height: 235px;
        border-radius: 12px;
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
</style>
@endsection

@section('content')
<div class="xl:w-3/4 mx-auto">
    <div class="xsm:mx-4 xxsm:mx-5 pt-10 mb-10 ">
        <h1 class="font-fira-sans font-medium text-4xl text-left leading-10 pb-5">{{__('Appointment Booking')}}</h1>

        <div class="Appointment-detail border border-white-light">
            <div class="progress-container">
                <div class="progress" id="progress"></div>
                <div class="circle progress_active">1</div>
                <div class="circle">2</div>
                <div class="circle">3</div>
            </div>
            <form id="appointmentForm">
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <input type="hidden" name="currency" value="{{ $setting->currency_code }}">
                <input type="hidden" name="company_name" value="{{ $setting->business_name }}">
                <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
                <input type="hidden" name="payment_type" value="COD">
                <input type="hidden" name="amount" step="any" value="{{ $doctor->appointment_fees }}">
                <input type="hidden" name="payment_token">
                <input type="hidden" name="payment_status" value="0">
                <input type="hidden" name="discount_price">
                <input type="hidden" name="discount_id">

                <div id="step1" class="block p-5">
                    <h1 class="font-fira-sans leading-6 text-xl font-medium pb-6">{{__('Patient Details')}}</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                        <div>
                            <label for="appointment_for" class="text-base font-normal font-fira-sans pb-2">{{__('Appointment For')}}</label>
                            <select id="appointment_for" aria-placeholder="appointment for" name="appointment_for" class="border border-white-light text-gray text-sm bg-white-50 focus:ring-primary focus:border-primary block w-full p-1.5 mt-2">
                                <option value="" disabled selected>{{ __('Appointment for') }}</option>
                                <option value="my_self" selected>{{__('For me')}}</option>
                                <option value="other">{{__('Other')}}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="illness_information">{{__('Illness Information')}}</label>
                            <input type="text" name="illness_information" class="block p-2 w-full text-sm bg-white-50 border font-normal font-fira-sans leading-5 !border-white-light mt-2" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mt-5">
                        <div>
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="patient_name">{{__('Patient Name')}}</label>
                            <input name="patient_name" type="text" class="block p-2 w-full text-sm bg-white-50 border font-normal font-fira-sans leading-5 !border-white-light mt-2" required value="{{ $patient_details['name'] }}">
                        </div>
                        <div>
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="patient_age">{{__('Patient Age')}}</label>
                            <input type="number" min="1" name="age" class="block p-2 w-full text-sm bg-white-50 border font-normal font-fira-sans leading-5 !border-white-light mt-2" required value="{{ $patient_details['age'] }}">
                        </div>
                        <div>
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="phone_number">{{__('Phone Number')}}</label>
                            <input type="number" min="1" name="phone_no" class="block p-2 w-full text-sm bg-white-50 border font-normal font-fira-sans leading-5 !border-white-light mt-2" required value="{{ $patient_details['phone'] }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-1 md:gap-1 lg:gap-1 mt-5">
                        <div class="flex justify-between">
                            <label class="text-base font-normal font-fira-sans leading-5" for="patient_address">{{__('Address')}}</label>
                            <button type="button" class="inline-block py-2.5 font-medium text-xs leading-tight uppercase rounded text-primary transition duration-150 ease-in-out" data-modal-target="exampleModalCenteredScrollable" data-modal-toggle="exampleModalCenteredScrollable" data-te-ripple-color="light" role="dialog">
                                {{ __('Add Address') }}
                            </button>
                        </div>
                        <select name="patient_address" id="patient_address" class="select2 w-full border !border-white-light text-gray text-sm bg-white-50 focus:border-primary block p-2.5 mt-2">
                            <option class="text-sm" value="" disabled selected>{{ __('Please Select The Address') }}</option>
                            @foreach ($patient_addressess as $patient_address)
                            <option class="text-sm" value="{{ $patient_address->id }}">{{ $patient_address->address }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 md:gap-6 lg:gap-8 mt-5">
                        <div>
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="drug_effect">{{__('Any Side Effects Of The Drug?')}}</label>
                            <input name="drug_effect" type="text" id="search-dropdown" class="block p-2 w-full text-sm bg-white-50 border font-normal font-fira-sans leading-5 !border-white-light mt-2" required>
                        </div>
                        <div>
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="note">{{__('Any Note For Doctor ??')}}</label>
                            <input name="note" type="text" id="search-dropdown" class="block p-2 w-full text-sm bg-white-50 border font-normal font-fira-sans leading-5 !border-white-light mt-2" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mt-5">
                        <div>
                        <label for="is_insured" class="text-base font-normal font-fira-sans pb-2">{{__('Patient Insured?')}}</label>
                            <select id="is_insured" aria-placeholder="is_insured" name="is_insured" class="border border-white-light text-gray text-sm bg-white-50 focus:ring-primary focus:border-primary block w-full p-1.5 mt-2">
                                <option value="0" selected>{{ __('No') }}</option>
                                <option value="1">{{__('Yes')}}</option>
                            </select>
                        </div>
                        <div class="policy_insurer hidden">
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="policy_provider">{{__('Choose Policy Provider')}}</label>
                            <select name="policy_insurer_name" id="policy_insurer_name" class="policy_insurer_name border border-white-light text-gray text-sm bg-white-50 focus:ring-primary focus:border-primary block w-full p-1.5 mt-2">
                                <option value="" disabled selected>{{ __('Please select the policy provider') }}</option>
                                @foreach ($insurers as $insurer)
                                    <option value="{{ $insurer->name }}">{{ $insurer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="policy_insurer hidden">
                            <label class="text-base font-normal font-fira-sans leading-5 pb-2" for="policy_number">{{__('Policy Number')}}</label>
                            <input type="number" min="1" maxlength="20" name="policy_number" class="policy_number block p-2 w-full text-sm bg-white-50 border font-normal font-fira-sans leading-5 !border-white-light mt-2" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mt-5">
                        <label class="text-base font-normal font-fira-sans leading-5 pb-2">{{__('Upload Patient Image & Report')}}</label>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                        <div>
                            <div class="drop-zone">
                                <h1 class="drop-zone__prompt text-center text-2xl"><i class="fa-solid fa-images"></i></h1>
                                <input type="file" name="report_image[]" class="drop-zone__input">
                                <h1 class="drop-zone__prompt font-fira-sans font-normal text-center text-xs leading-3 py-2">{{__('Drop your image or')}} <span class="text-primary">{{__('Browse')}}</span></h1>
                                <p class="drop-zone__prompt font-fira-sans font-normal text-center text-xs leading-3 text-gray">{{__('Support: JPEG, PNG')}}</p>
                                {{-- <span class="drop-zone__prompt">Drop file here or click to upload</span>
                            <input type="file" name="myFile" class="drop-zone__input"> --}}
                            </div>
                        </div>
                        <div>
                            <div class="drop-zone">
                                <h1 class="drop-zone__prompt text-center text-2xl"><i class="fa-solid fa-images"></i></h1>
                                <input type="file" name="report_image[]" class="drop-zone__input">
                                <h1 class="drop-zone__prompt font-fira-sans font-normal text-center text-xs leading-3 py-2">{{__('Drop your image or')}} <span class="text-primary">{{__('Browse')}}</span></h1>
                                <p class="drop-zone__prompt font-fira-sans font-normal text-center text-xs leading-3 text-gray">{{__('Support: JPEG, PNG')}}</p>
                            </div>
                        </div>
                        <div>
                            <div class="drop-zone">
                                <h1 class="drop-zone__prompt text-center text-2xl"><i class="fa-solid fa-images"></i></h1>
                                <input type="file" name="report_image[]" class="drop-zone__input">
                                <h1 class="drop-zone__prompt font-fira-sans font-normal text-center text-xs leading-3 py-2">{{__('Drop your image or')}} <span class="text-primary">{{__('Browse')}}</span></h1>
                                <p class="drop-zone__prompt font-fira-sans font-normal text-center text-xs leading-3 text-gray">{{__('Support: JPEG, PNG')}}</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="step2" class="hidden">
                    <div class="flex xxsm:flex-col sm:flex-row">
                        <div class="2xl:w-1/2 border-r xxsm:w-full">
                            @php
                            $date = Carbon\Carbon::now(env('timezone'));
                            @endphp
                            <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                            @if (Session::get('locale') ==='Arabic')
                                <div id="datepickerId" onclick="dateChange()" data-date="{{ $date->format('Y-m-d') }}" class="rtl"></div>
                            @elseif(Session::get('locale') ==='English')
                                <div id="datepickerId" onclick="dateChange()" data-date="{{ $date->format('Y-m-d') }}"></div>
                            @endif
                            <div class="p-5">
                                <div class="mt-2 font-normal text-xl font-fira-sans">
                                    <span class="currentDate">{{ $date->format('d M') }}</span>{{ __(' Availibility') }}
                                </div>
                                <div class="mt-2">
                                    <div class="flex flex-wrap timeSlotRow">
                                        @if (count($today_timeslots)> 0)
                                        @foreach ($today_timeslots as $today_timeslot)
                                        @if ($loop->first)
                                        <input type="hidden" name="time" value="{{ $today_timeslot['start_time'] }}">
                                        @endif
                                        <a href="javascript:void(0)" onclick="thisTime({{ $loop->iteration }})" class="time timing{{ $loop->iteration }} border border-gray text-center py-1 2xl:text-sm 2xl:px-2 sm:text-sm sm:px-2 msm:text-sm msm:px-2 leading-4 font-fira-sans font-normal xl:text-xs xl:px-1 xlg:text-xs xlg:px-1 xlg:w-28 lg:w-28 xsm:w-28 xxsm:w-28 text-black m-1 {{ $loop->first ? 'activeTimeslots' : '' }}">
                                            <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 11.75C4.60761 11.75 3.27226 11.1969 2.28769 10.2123C1.30312 9.22774 0.75 7.89239 0.75 6.5C0.75 5.10761 1.30312 3.77226 2.28769 2.78769C3.27226 1.80312 4.60761 1.25 6 1.25C7.39239 1.25 8.72774 1.80312 9.71231 2.78769C10.6969 3.77226 11.25 5.10761 11.25 6.5C11.25 7.89239 10.6969 9.22774 9.71231 10.2123C8.72774 11.1969 7.39239 11.75 6 11.75ZM6 12.5C7.5913 12.5 9.11742 11.8679 10.2426 10.7426C11.3679 9.61742 12 8.0913 12 6.5C12 4.9087 11.3679 3.38258 10.2426 2.25736C9.11742 1.13214 7.5913 0.5 6 0.5C4.4087 0.5 2.88258 1.13214 1.75736 2.25736C0.632141 3.38258 0 4.9087 0 6.5C0 8.0913 0.632141 9.61742 1.75736 10.7426C2.88258 11.8679 4.4087 12.5 6 12.5V12.5Z" fill="white" />
                                                <path d="M8.22727 4.22747C8.22192 4.23264 8.21691 4.23816 8.21227 4.24397L5.60752 7.56272L4.03777 5.99222C3.93113 5.89286 3.7901 5.83876 3.64437 5.84134C3.49865 5.84391 3.35961 5.90294 3.25655 6.006C3.15349 6.10906 3.09446 6.2481 3.09188 6.39382C3.08931 6.53955 3.14341 6.68059 3.24277 6.78722L5.22727 8.77247C5.28073 8.82583 5.34439 8.86788 5.41445 8.89611C5.48452 8.92433 5.55955 8.93816 5.63507 8.93676C5.7106 8.93536 5.78507 8.91876 5.85404 8.88796C5.92301 8.85716 5.98507 8.81278 6.03652 8.75747L9.03052 5.01497C9.13246 4.90796 9.1882 4.76514 9.18568 4.61737C9.18317 4.4696 9.12259 4.32875 9.01706 4.22529C8.91152 4.12182 8.76951 4.06405 8.62171 4.06446C8.47392 4.06486 8.33223 4.12342 8.22727 4.22747Z" fill="white" />
                                            </svg>
                                            {{ $today_timeslot['start_time'] }}
                                        </a>
                                        @endforeach
                                        @else
                                        <strong class="text-red-600 text-bs text-center w-100">{{ __('At this time doctor is not available please change the date.') }}</strong>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="2xl:w-2/5 p-8 xxsm:w-full">
                            <div>
                                <h4 class="font-fira-sans font-normal text-1xl text-left pb-5">{{ __('Choose Clinic') }}</h4>
                            </div>
                            @foreach ($doctor->hospital as $hospital)
                            @if ($loop->first)
                            @php
                            $hospital_name = $hospital->name;
                            $address = $hospital->address;
                            @endphp
                            <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
                            @endif
                            <div onclick="changeHospital({{ $loop->iteration }})" data-attribute="{{ $hospital->id }}" class="border hospitals hospital{{ $loop->iteration }} border-1 border-gray-200 p-2 cursor-pointer {{ $loop->first ? 'activeAddress' : ' mt-4' }}">
                                <div>
                                    <h5 class="font-fira-sans font-medium text-1xl text-left hospitalName{{ $loop->iteration }}">{{ $hospital->name }}</h5>
                                </div>
                                <div class="flex mt-1 items-center">
                                    <i class="fa-solid fa-location-dot mr-3"></i>
                                    <p class="font-fira-sans hospitalAddress{{ $loop->iteration }}">{{ $hospital->address }}</p>
                                </div>
                                <div class="flex displayHospital justify-between mt-2">
                                    <p class="text-gray font-fira-sans">
                                        <span class="font-fira-sans displayKm{{ $hospital->id }}"></span>{{ (' km away') }}
                                    </p>
                                    @php
                                    $url = 'https://www.google.com/maps/dir/?api=1&destination='.$hospital->lat.','.$hospital->lng;
                                    @endphp
                                    <a href="{{ $url }}" target="_blank" class="font-medium font-fira-sans">{{ __('View Details') }}</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="step3" class="hidden">
                    <div class="flex xlg:flex-row xxsm:flex-col">
                        <div class="col-span-5 p-5 w-full">
                            <label for="search" class="mb-2 text-sm font-medium text-gray dark:text-white mt-4 font-fira-sans">{{ __('Offer code') }}</label>
                            <div class="relative">
                                <input type="text" name="coupon_code" id="coupon_code" class="block font-fira-sans w-full p-2 text-sm text-gray border !border-white-light rounded-sm focus:ring-primary focus:border-primary" placeholder="{{ __('Enter coupon code') }}">
                                <button type="button" class="text-primary absolute right-2.5 bottom-2.5 font-medium rounded-lg text-sm dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary applyCoupon">{{ __('Apply') }}</button>
                            </div>

                            <h2 class="font-fira-sans font-medium mt-4 text-2xl">{{ __('Payment Method') }}</h2>
                            <div class="grid grid-cols-1 gap-1 md:grid-cols-4 msm:grid-cols-2">
                                <div>
                                    @if ($setting->cod)
                                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-5 activePayment" data-attribute="cod">
                                        <img class="m-auto" width="50px" height="20px" src="{{ url('assets/image/cod.png') }}" alt="">
                                        <p class="mt-3 overflow-hidden">{{ __('COD') }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    @if ($setting->paypal)
                                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-5" data-attribute="paypal">
                                        <img class="m-auto" width="16px" height="18px" src="{{ url('assets/image/logos_paypal.png') }}" alt="">
                                        <p class="mt-3 overflow-hidden">{{ __('Paypal') }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    @if ($setting->stripe)
                                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-5" data-attribute="stripe">
                                        <img class="m-auto" width="48px" height="20px" src="{{ url('assets/image/logos_stripe.png') }}" alt="">
                                        <p class="mt-3 overflow-hidden">{{ __('Stripe') }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    @if ($setting->paystack)
                                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-5" data-attribute="paystack">
                                        <img class="m-auto" width="87px" height="15px" src="{{ url('assets/image/paystack.png') }}" alt="">
                                        <p class="mt-3 overflow-hidden">{{ __('Paystack') }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    @if ($setting->flutterwave)
                                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-4" data-attribute="flutterwave">
                                        <img class="m-auto" width="89px" height="24px" src="{{ url('assets/image/flutterwave.png') }}" alt="">
                                        <p class="mt-3 overflow-hidden">{{ __('Flutterwave') }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    @if ($setting->razor)
                                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-4" data-attribute="razorpay">
                                        <img class="m-auto" width="29px" height="29px" src="{{ url('assets/image/razorpay.png') }}" alt="">
                                        <p class="mt-3 overflow-hidden">{{ __('Razorpay') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="codDiv text-center">
                                <button class="font-fira-sans text-white !bg-primary p-3 text-sm font-normal h-11 cursor-pointer mt-10" onclick="booking()" id="btnPayCOD">
                                    <span id="bookingloading" style="display: none"> <i class="fa fa-spinner animate-spin" aria-hidden="true"></i> </span> {{__('Pay Cash on Delivery')}}
                                </button>
                            </div>
                            <div class="paypalDiv hidden">
                                <div class="paypal_row_body justify-center">

                                </div>
                            </div>
                            <div class="stripDiv hidden">
                                <div class="bg-red-100 stripe_alert hidden rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full" role="alert">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
                                    </svg>
                                    <div class="stripeText"></div>
                                </div>
                                <input type="hidden" name="stripe_publish_key" value="{{$setting->stripe_public_key}}">
                                <form role="form" method="post" class="require-validation customform" data-cc-on-file="false" id="stripe-payment-form">
                                    @csrf
                                    <div class="row p-4">
                                        <div class="form-group">
                                            <label class="font-fira-sans font-medium text-bs">{{__('Email')}}</label>
                                            <input type="email" class="mt-3 font-fira-sans required block p-2 w-full z-20 text-sm border font-normal leading-5 !border-white-light" title="Enter Your Email" name="email" required />
                                        </div>
                                        <div class="mt-3">
                                            <label class="font-fira-sans font-medium text-bs">{{__('Card Information')}}</label>
                                            <input type="number" step="1" class="card-number font-fira-sans mt-3 required block p-2 w-full z-20 text-sm border font-normal leading-5 !border-white-light" title="please input only number." pattern="[0-9]{16}" name="card-number" placeholder="1234 1234 1234 1234" title="Card Number" required />
                                        </div>
                                        <div class="flex" class="mt-1">
                                            <div class="w-1/2">
                                                <input type="text" class="mt-3 mr-1 font-fira-sans expiry-date required block p-2 w-full z-20 text-sm border font-normal leading-5 !border-white-light" name="expiry-date" title="Expiration date" title="please Enter data in MM/YY format." pattern="(0[1-9]|10|11|12)/[0-9]{2}$" placeholder="MM/YY" required />
                                                <input type="hidden" class="card-expiry-month required form-control" name="card-expiry-month" />
                                                <input type="hidden" class="card-expiry-year required form-control" name="card-expiry-year" />
                                            </div>
                                            <div class="w-1/2">
                                                <input type="text" class="card-cvc font-fira-sans mt-3 ml-1 required block p-2 w-full z-20 text-sm border font-normal leading-5 !border-white-light" title="please input only number." pattern="[0-9]{3}" name="card-cvc" placeholder="CVC" title="CVC" required />
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="form-group">
                                                <label class="font-fira-sans font-medium text-bs">{{__('Name on card')}}</label>
                                                <input type="text" class="mt-3 font-fira-sans required block p-2 w-full z-20 text-sm border font-normal leading-5 !border-white-light" name="name" title="Name on Card" required />
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="form-group text-center">
                                                <input type="button" class="btn-submit font-fira-sans !text-white !bg-primary w-full text-sm font-normal py-3 cursor-pointer" value="{{ __('Pay with stripe') }}" />
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
                                        <input type="button" onclick="payStack()" class="font-fira-sans text-white !bg-primary p-3 text-sm font-normal py-3 cursor-pointer" onclick="payWithPaystack()" value="{{__('Pay with paystack')}}">
                                    </div>
                                </form>
                            </div>
                            <div class="flutterwaveDiv hidden">
                                <form>
                                    <input type="hidden" name="flutterwave_key" value="{{ $setting->flutterwave_key }}">
                                    <div class="w-full px-4 flex gap-3 items-center mt-5 rounded-md h-auto justify-center">
                                        <input type="button" onclick="makePayment(event)" class="font-fira-sans text-white !bg-primary
                                    p-3 text-sm font-normal py-3 cursor-pointer" value="{{__('Pay With Flutterwave')}}">
                                    </div>
                                </form>
                            </div>
                            <div class="razorpayDiv text-center mt-5 hidden">
                                <input type="hidden" id="RAZORPAY_KEY" value="{{ $setting->razor_key }}">
                                <input type="button" id="paybtn" onclick="RazorPayPayment()" value="{{__('Pay with Razorpay')}}" class="font-fira-sans text-white !bg-primary p-3 text-sm font-normal py-3 cursor-pointer">
                            </div>
                        </div>
                        <div class="xxsm:w-full lg:w-[33%]">
                            <div class="border xxsm:border-t lg:!border-t-0 !border-white-light p-10">
                                <img class="2xl:w-28 2xl:h-28 1xl:w-28 1xl:h-28 xlg:h-24 xlg:w-24 xl:h-24 xl:w-24 lg:h-24 lg:w-24 xxmd:w-24 xxmd:h-24 md:h-20 md:w-20 sm:h-20 sm:w-20 xsm:h-16 xsm:w-16 msm:h-24 msm:w-24 xxsm:h-14 xxsm:w-14 border border-primary rounded-full p-0.5 m-auto" src="{{ url($doctor->fullImage) }}" alt="" />
                                {{-- <img class="!2xl:w-28 !2xl:h-28 !1xl:w-28 !1xl:h-28 !xlg:h-24 !xlg:w-24 !xl:h-24 !xl:w-24 !lg:h-24 !lg:w-24 !xxmd:w-24 !xxmd:h-24 !md:h-20 !md:w-20 !sm:h-20 !sm:w-20 !xsm:h-16 !xsm:w-16 !msm:h-24 !msm:w-24 !xxsm:h-14 !xxsm:w-14 border border-primary rounded-full p-0.5 m-auto" src="{{ url($doctor->fullImage) }}"alt="" /> --}}
                                <h5 class="font-fira-sans font-normal text-lg leading-6 text-black text-center md:text-md pt-5">{{ $doctor->name }}</h5>
                                <p class="font-normal leading-4 text-sm text-primary text-center font-fira-sans md:text-md py-2">{{ $doctor['category']['name'] }}</p>
                                <p class="font-fira-sans font-normal leading-4 text-sm text-gray text-center md:text-md"><i class="fa-solid fa-star text-yellow"></i> {{ $doctor['rate'] }}&nbsp;({{ $doctor['review'] }}{{ __(' reviews') }})</p>
                            </div>
                            <div class="border !border-t-0 border-white-light p-5">
                                <div>
                                    <h5 class="font-fira-sans font-medium text-1xl text-left displayHospitalName">{{ $hospital_name }}</h5>
                                </div>
                                <div class="flex mt-1 items-center">
                                    <i class="fa-solid fa-location-dot mr-3"></i>
                                    <p class="displayAddress font-fira-sans ">{{ $address }}</p>
                                </div>
                                <div class="font-fira-sans mt-4">
                                    {{ __('Appointment Fees : ') }} <span class="text-base font-medium text-primary">{{ $currency }}<span class="appointmentFees">{{ $doctor->appointment_fees }}</span></span>
                                </div>
                                <div class="font-fira-sans mt-4">
                                    {{ __('Discount Amount : ') }}<span class="text-base font-medium text-primary">{{ $currency }}<span class="discountAmount">00</span></span>
                                </div>
                                <div class="font-fira-sans mt-4">
                                    {{ __('Final Amount : ') }}<span class="text-base font-medium text-primary">{{ $currency }}<span class="finalAmount">{{ $doctor->appointment_fees }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="Appointment-detail flex justify-between mt-3 mb-3">
            <button type="button" class="border !border-primary text-white !bg-primary text-center w-32 h-11 text-base font-normal leading-5 font-fira-sans" id="prev" disabled>{{ __('Previous') }}</button>
            <button type="button" class="!text-white !bg-primary text-center text-base font-normal font-fira-sans w-32 h-11" id="next">{{ __('Next')}}</button>
        </div>
    </div>

    <div class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="exampleModalCenteredScrollable" tabindex="-1" role="dialog">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 transition-all duration-300 ease-in-out w-full max-w-2xl max-h-full">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white-50 bg-clip-padding rounded-md outline-none text-current">
                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-white-light rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalCenteredScrollableLabel">
                        {{ __('Add Address') }}
                    </h5>
                    <button type="button" data-te-modal-dismiss class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" data-modal-hide="exampleModalCenteredScrollable" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="modal-body relative p-4">
                    <form class="addAddress" method="post">
                        <input type="hidden" name="from" value="add_new">
                        <div class="w-auto border border-white-light" id="map" style="height: 200px">{{ __('Rajkot') }}</div>
                        <input type="hidden" name="lat" id="lat" value="{{ $setting->lat }}">
                        <input type="hidden" name="lang" id="lng" value="{{ $setting->lang }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <textarea name="address" class="mt-2 form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white-50 bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleFormControlTextarea1" rows="3" placeholder="Your message"></textarea>
                        <span class="invalid-div text-red"><span class="address text-sm  text-red-600 font-fira-sans"></span></span>
                    </form>
                </div>
                <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-white-light rounded-b-md">
                    <button type="button" data-modal-hide="exampleModalCenteredScrollable" data-te-ripple-color="light" class="modelCloseBtn inline-block px-6 py-2.5 bg-white-50 text-gray font-medium text-xs leading-tight uppercase rounded shadow-md active:shadow-lg transition duration-150 ease-in-out">{{ __('Close') }}</button>
                    <button type="button" onclick="addAddress()" class="inline-block px-6 py-2.5 !bg-primary text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">{{ __('Add Address') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>
<script src="https://unpkg.com/flowbite-datepicker@1.2.2/dist/js/datepicker-full.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
@if(App\Models\Setting::first()->paystack_public_key)
<script src="https://js.paystack.co/v2/inline.js"></script>
@endif
<script src="{{ url('payment/razorpay.js')}}"></script>

@if ($setting->paypal)
<script src="https://www.paypal.com/sdk/js?client-id={{ App\Models\Setting::first()->paypal_client_id }}&currency={{ App\Models\Setting::first()->currency_code }}" data-namespace="paypal_sdk"></script>
@endif
<script src="{{ url('payment/stripe.js')}}"></script>
<script src="{{ url('assets/js/appointment.js') }}"></script>

@if (App\Models\Setting::first()->map_key)
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
@endif
<script>
    var datepicker = '';
    const datepickerEl = document.getElementById('datepickerId');
    datepicker = new Datepicker(datepickerEl, {
        format: 'yyyy-mm-dd',
        minDate: '{{ $date->format("Y-m-d") }}',
        todayHighlight: true,
        prevArrow: '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.68771 1.5649e-08L8 1.37357L2.62459 7L8 12.6264L6.68771 14L8.34742e-08 7L6.68771 1.5649e-08Z" fill="#000"/></svg>',
        nextArrow: '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.31229 14L-6.00408e-08 12.6264L5.37541 7L-5.51919e-07 1.37357L1.31229 -5.73622e-08L8 7L1.31229 14Z" fill="#000"/></svg>',
    });

    $('select[name=is_insured]').on('change', function () {
        if(this.value == '1')
        {
            $('.policy_insurer').show();
            $('.policy_number').prop('required',true);
            $('.policy_insurer_name').prop('required',true);
        }
        else
        {
            $('.policy_insurer').hide();
            $('.custom_timeslot_text').prop('required',false);
            $('.policy_insurer_name').prop('required',false);
        }
    });
</script>
@endsection

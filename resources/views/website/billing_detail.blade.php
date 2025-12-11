@extends('layout.mainlayout',['activePage' => 'pharmacy'])

@section('css')
<style>
    .paymentDiv {
        width: 148px !important;
        height: 87px !important;
        padding-top: 1rem !important;
        cursor: pointer;
    }

    .activePayment {
        color: #2563eb !important;
        background: #f4fbfd !important;
    }
</style>
@endsection

@section('content')
@php
$price = array_sum(array_column(Session::get('cart'), 'price'));
@endphp
<input type="hidden" name="currency_code" value="{{ $master['setting']->currency_code }}">

<input type="hidden" name="company_name" value="{{$master['setting']->business_name}}">
<input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
<input type="hidden" name="email" value="{{ auth()->user()->email }}">
<input type="hidden" name="phone" value="{{ auth()->user()->phone }}">

<input type="hidden" name="shipping_at" value="pharmacy">
<input type="hidden" name="amount" value="{{ $price }}" step="any">
<input type="hidden" name="delivery_charge" value="0">
<div class="xl:w-3/4 mx-auto">
    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0 pt-10 pb-20">
        <h1 class="font-fira-sans font-medium text-4xl text-left leading-10 pb-5">{{__('Billing details')}}</h1>

        <div class="flex w-full 2xl:mx-0 xl:mx-5 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-col xsm:flex-col xxsm:flex-col gap-10">
            <div class="border border-white-light p-5 2xl:w-3/4 xl:w-3/4 xlg:w-3/4 lg:w-3/4 xmd:w-3/4 md:w-3/4 sm:w-3/4 xsm:w-full xxsm:w-full mb-10">
                <h1 class="font-fira-sans leading-6 text-xl font-medium pb-4">{{__('Personal Details ')}}</h1>
                <div class="form-check">
                    @if($master['is_shipping'] == 1)
                    <input id="delivery_type" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckChecked">
                    <label class="font-fira-sans form-check-label inline-block text-gray-800" for="delivery_type">
                        {{__('Shipping At Home ?')}}
                    </label>
                    @else
                    <label class="font-fira-sans form-check-label inline-block text-gray-800">
                        {{__('Shipping not available, Please pickup from Pharmacy')}}
                    </label>
                    @endif
                </div>
                <div>
                    <div class="border border-gray-light rounded-2 mt-4 hidden addresses-list px-3 pb-3">
                        <div class="flex justify-between border-b border-gray-light p-3 align-items-center shipping-details mb-2">
                            <h3 class="location-name font-fira-sans">{{__('Shipping Details') }}</h3>
                            <div class="success-block w-auto">
                                <a class="font-fira-sans text-sm text-primary" href="javascript:void(0)" data-te-toggle="modal" data-te-target="#exampleModalCenter">{{__('Add new Address')}}</a>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="displayAddress">
                                @foreach ($master['address'] as $address)
                                <div class="form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" id="address{{ $address['id'] }}" value="{{ $address['id'] }}" name="address_id" {{ $loop->first ? 'checked' : '' }}>
                                    <label class="form-check-label font-fira-sans text-sm inline-block text-gray-800" for="address{{ $address['id'] }}">
                                        {{ $address['address'] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="prescription_require" value="{{ $master['prescription'] }}"/>
                <div class="px-2 py-2  {{ $master['prescription'] == 0 ? 'hidden' : ''}}">
                    <p class="mb-1 mt-3 text-sm font-fira-sans prescription-txt">{{__('Add Prescription PDF') }} <span class="text-red">{{__('**Please First Add Doctor Prescription**') }}</span></p>
                    <input type="file" name="pdf" accept=".pdf" id="pdf" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border
                 border-gray-light rounded transition ease-in-out m-0 focus:text-gray-700 focus focus:border-primary focus:outline-none">
                </div>

                <div class="payment_style {{ $master['prescription'] == 1 ? 'hidden' : ''}}">
                    <h2 class="font-fira-sans font-medium mt-4 text-2xl mb-10">{{__('Payment Method') }}</h2>
                    <div class="flex xxsm:flex-col lg:flex-row mb-10 gap-10">
                        @if ($setting->cod)
                        <div class="border border-white-100 font-fira-sans paymentDiv text-center activePayment" data-attribute="cod">
                            <img class="m-auto" width="50px" height="20px" src="{{ url('assets/image/cod.png') }}" alt="">
                            <p class="mt-3">{{__('COD') }}</p>
                        </div>
                        @endif
                        @if ($setting->paypal)
                        <div class="border border-white-100 font-fira-sans paymentDiv text-center" data-attribute="paypal">
                            <img class="m-auto" width="16px" height="18px" src="{{ url('assets/image/logos_paypal.png') }}" alt="">
                            <p class="mt-3">{{__('Paypal') }}</p>
                        </div>
                        @endif
                        @if ($setting->stripe)
                        <div class="border border-white-100 font-fira-sans paymentDiv text-center" data-attribute="stripe">
                            <img class="m-auto" width="48px" height="20px" src="{{ url('assets/image/logos_stripe.png') }}" alt="">
                            <p class="mt-3">{{__('Stripe') }}</p>
                        </div>
                        @endif
                        @if ($setting->paystack)
                        <div class="border border-white-100 font-fira-sans paymentDiv text-center" data-attribute="paystack">
                            <img class="m-auto" width="87px" height="15px" src="{{ url('assets/image/paystack.png') }}" alt="">
                            <p class="mt-3">{{__('Paystack') }}</p>
                        </div>
                        @endif
                        @if ($setting->flutterwave)
                        <div class="border border-white-100 font-fira-sans paymentDiv text-center" data-attribute="flutterwave">
                            <img class="m-auto" width="89px" height="24px" src="{{ url('assets/image/flutterwave.png') }}" alt="">
                            <p class="mt-3">{{__('Flutterwave') }}</p>
                        </div>
                        @endif
                        @if ($setting->razor)
                        <div class="border border-white-100 font-fira-sans paymentDiv text-center" data-attribute="razorpay">
                            <img class="m-auto" width="29px" height="29px" src="{{ url('assets/image/razorpay.png') }}" alt="">
                            <p class="mt-3">{{__('Razorpay') }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="codDiv text-center">
                        <input type="button" class="font-fira-sans text-white bg-primary p-3 text-sm font-normal py-3 cursor-pointer" onclick="bookMedicine()" value="{{__('Pay Cash on Delivery')}}">
                    </div>
                    <div class="paypalDiv hidden">
                        <div class="paypal_row_body">

                        </div>
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
                                        <input type="button" class="btn-submit font-fira-sans text-white bg-primary w-full text-sm font-normal py-3 cursor-pointer" value="{{__('Pay with stripe') }}" />
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
                                <input type="button" onclick="payStack()" class="font-fira-sans text-white bg-primary p-3 text-sm font-normal py-3 cursor-pointer" onclick="payWithPaystack()" value="{{__('Pay with paystack')}}">
                            </div>
                        </form>
                    </div>
                    <div class="flutterwaveDiv hidden">
                        <form>
                            <input type="hidden" name="flutterwave_key" value="{{ $setting->flutterwave_key }}">
                            <div class="w-full px-4 flex gap-3 items-center mt-5 rounded-md h-auto justify-center">
                                <input type="button" class="font-fira-sans text-white bg-primary p-3 text-sm font-normal py-3 cursor-pointer" onclick="makePayment(event)" value="{{__('Pay With Flutterwave')}}">
                            </div>
                        </form>
                    </div>
                    <div class="razorpayDiv text-center mt-5 hidden">
                        <input type="hidden" id="RAZORPAY_KEY" value="{{ $setting->razor_key }}">
                        <input type="button" id="paybtn" onclick="RazorPayPayment()" value="{{__('Pay with Razorpay')}}" class="font-fira-sans text-white bg-primary p-3 text-sm font-normal py-3 cursor-pointer">
                    </div>
                </div>
            </div>

            <div class="p-8" style="background: #f4fbfd;">
                <h1 class="font-fira-sans font-normal leading-5 text-xl pb-4">{{__('Your Order')}}</h1>

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-b border-white-light pb-7">
                    <thead class="text-xs  text-gray ">
                        <tr class="">
                            <th scope="col" class="py-3 ">
                                {{__('Product')}}
                            </th>
                            <th scope="col" class="py-3 px-6 text-black">
                                {{__('Total')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach (Session::get('cart') as $cart)
                        <tr class="border-b border-white-light">
                            <th scope="row" class="flex 2xl:flex-row  xl:flex-col xlg:flex-col lg:flex-col xmd:flex-col  md:flex-col sm:flex-row msm:flex-row  xxsm:flex-col items-center py-4  text-gray-900 whitespace-nowrap dark:text-white">
                                <img width="41px" height="41px" src="{{ $cart['image'] }}" alt="">
                                <div class="pl-3">
                                    <div class="text-sm font-normal font-fira-sans">{{ $cart['name'] }}</div>
                                </div>
                            </th>
                            <td class="py-4 px-6 font-medium font-fira-sans text-sm leading-5">
                                {{ $setting->currency_symbol }}{{ $cart['original_price'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex justify-between border-b border-white-light py-2">
                    <div>
                        <h1 class="font-fira-sans text-sm font-normal leading-5 text-gray">{{__('Subtotal')}}</h1>
                    </div>
                    <div>
                        <h1 class="font-fira-sans text-sm font-medium leading-5 text-black">{{ $setting->currency_symbol
                        }}<span class="subtotal">{{ $price }}</span></h1>
                    </div>
                </div>
                @if($master['is_shipping'] == 1)
                <div class="flex justify-between border-b border-white-light py-2">
                    <div>
                        <h1 class="font-fira-sans text-sm font-normal leading-5 text-gray">{{__('Shipping')}}</h1>
                    </div>
                    <div>
                        <h1 class="font-fira-sans text-sm font-medium leading-5 text-black">{{ $setting->currency_symbol
                        }}<span class="deliveryCharge">00</span></h1>
                    </div>
                </div>
                @endif
                <div class="flex justify-between pt-2 pb-8">
                    <div>
                        <h1 class="font-fira-sans text-sm font-medium leading-5 text-black">{{__('Total')}}</h1>
                    </div>
                    <div>
                        <h1 class="font-fira-sans text-sm font-medium leading-5 text-black">{{ $setting->currency_symbol}}<span class="finalPrice">{{ $price }}</span></h1>
                    </div>
                </div>

                <button type="button" onclick="bookMedicine()" class="w-full text-white bg-primary text-center px-4 py-2 text-base font-normal leading-5 font-fira-sans ">{{__('CheckOut')}}</button>
            </div>
        </div>

    </div>
</div>

<div data-te-modal-init class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
    <div data-te-modal-dialog-ref class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalCenterLabel"> {{__('User Address') }}</h5>
                <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="relative overflow-y-auto p-4">
                <form class="addAddress" method="post">
                    <div class="w-auto border border-gray-light" id="map" style="height: 200px">{{__('Rajkot') }}</div>
                    <input type="hidden" name="lat" id="lat" value="{{$setting->lat}}">
                    <input type="hidden" name="lang" id="lng" value="{{$setting->lang}}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <textarea name="address" class="mt-2 form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus focus:border-primary focus:outline-none" id="exampleFormControlTextarea1" rows="3">{{__('Rajkot,Gujrat') }}</textarea>
                </form>
            </div>
            <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <button type="button" class="inline-block rounded bg-white-100 px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200" data-te-modal-dismiss>
                    Close
                </button>
                <button type="button" onclick="addAddress()" class="ml-1 inline-block rounded bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"> Save changes
                </button>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@section('js')
@if (App\Models\Setting::first()->map_key)
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&libraries=places&v=weekly" async></script>
@endif
<script src="{{ url('assets/js/medicine_list.js') }}"></script>
{{-- <script src="{{ asset('payment/flutterwave.js') }}"></script> --}}
<script src="{{ url('payment/stripe.js')}}"></script>

@if(App\Models\Setting::first()->flutterwave_key)
<script src="https://checkout.flutterwave.com/v3.js"></script>
@endif


@if(App\Models\Setting::first()->paypal_client_id)
<script src="https://www.paypal.com/sdk/js?client-id={{ App\Models\Setting::first()->paypal_client_id }}&currency={{ App\Models\Setting::first()->currency_code }}" data-namespace="paypal_sdk"></script>
@endif

<script src="{{ url('payment/razorpay.js')}}"></script>

@if(App\Models\Setting::first()->paystack_public_key)
<script src="https://js.paystack.co/v2/inline.js"></script>
@endif
@endsection

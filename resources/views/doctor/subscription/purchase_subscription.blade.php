@extends('layout.mainlayout_admin',['activePage' => 'subscription'])

@section('title',__('Purchase Subscription'))
<style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      text-decoration: none;
      list-style: none;
    }

</style>

@section('subscription')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Purchase Subscription'),
    ])
    <div class="section_body">
        <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
        <input type="hidden" name="currency" value="{{ $setting->currency_code }}">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="pricing-table">
                            <div class="pricing-card">
                                <h3 class="pricing-card-header">{{ $subscription->name }}</h3>
                                <div class="price">{{ $subscription->total_appointment }}<span> {{__('Booking')}}</span></div>
                                <ul>
                                    @foreach (json_decode($subscription->plan) as $plan)
                                        <li>
                                            <input type="radio" name="plan" value="{{ $plan->price }}/{{ $plan->month }}" id="plan{{$loop->iteration}}" {{ $loop->iteration == 1 ? 'checked' : '' }}>
                                            <label for="plan{{$loop->iteration}}">
                                                <strong>{{ $setting->currency_symbol }}{{ $plan->price }}/</strong>
                                                {{ $plan->month }}{{__('month')}}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body d-flex">
                                <table class="table">
                                    @if ($setting->paypal == 1)
                                            <div class="custom-control custom-radio ml-2">
                                                <input type="radio" id="paypal" name="paymentradio" value="paypal" class="custom-control-input">
                                                <label class="custom-control-label float-right" for="paypal">{{__('Paypal')}}</label>
                                            </div>
                                    @endif
                                    @if ($setting->razor == 1)
                                    <input type="hidden" id="RAZORPAY_KEY" value="{{ $setting->razor_key }}">
                                            <div class="custom-control custom-radio ml-2">
                                                <input type="radio" id="razor" name="paymentradio" value="razor" class="custom-control-input">
                                                <label class="custom-control-label" for="razor">{{__('Razorpay')}}</label>
                                            </div>
                                    @endif
                                    @if ($setting->stripe == 1)
                                            <div class="custom-control custom-radio ml-2">
                                                <input type="radio" id="stripe" name="paymentradio" value="stripe" class="custom-control-input">
                                                <label class="custom-control-label" for="stripe">{{__('Stripe')}}</label>
                                            </div>
                                    @endif
                                    @if ($setting->paystack == 1)
                                        <div class="custom-control custom-radio ml-2">
                                            <input type="radio" id="paystack" name="paymentradio" value="paystack" class="custom-control-input">
                                            <label class="custom-control-label" for="paystack">{{__('PayStack')}}</label>
                                        </div>
                                    @endif
                                    @if ($setting->flutterwave == 1)
                                        <div class="custom-control custom-radio ml-2">
                                            <input type="radio" id="flutterwave" name="paymentradio" value="flutterwave" class="custom-control-input">
                                            <label class="custom-control-label" for="flutterwave">{{__('Flutterwave ')}}</label>
                                        </div>
                                    @endif
                                    @if ($setting->cod == 1)
                                        <div class="custom-control custom-radio ml-2">
                                            <input type="radio" id="cod" name="paymentradio" value="cod" class="custom-control-input">
                                            <label class="custom-control-label" for="cod">{{__('COD')}}</label>
                                        </div>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="card hide paypal_card">
                            <div class="card-header">
                                <strong>{{__('paypal')}}</strong>
                            </div>
                            <div class="card-body paypal_card_body">

                            </div>
                        </div>
                        <div class="card hide razor_card">
                            <div class="card-header">
                                <strong>{{__('razor pay')}}</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <input type="button" id="paybtn" value="{{__('pay with razor pay')}}" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card hide stripe_card">
                            <div class="card-header">
                                <strong>{{__('stripe')}}</strong>
                                <div class="alert alert-warning alert-dismissible fade show hide stripe_alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" action="" method="post" class="require-validation customform" data-cc-on-file="false" data-stripe-publishable-key="{{App\Models\Setting::find(1)->stripe_public_key}}" id="stripe-payment-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{__('Email')}}</label>
                                                <input type="email" class="email form-control required" title="Enter Your Email"
                                                    name="email" required />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{__('Card Information')}}</label>
                                                <input type="text" class="card-number required form-control" title="please input only number." pattern="[0-9]{16}" name="card-number" placeholder="1234 1234 1234 1234" title="Card Number" required />
                                                <div class="row" class="mt-1">
                                                    <div class="col-lg-6 pr-0">
                                                        <input type="text" class="expiry-date required form-control" name="expiry-date" title="Expiration date" title="please Enter data in MM/YY format." pattern="(0[1-9]|10|11|12)/[0-9]{2}$" placeholder="MM/YY" required />
                                                        <input type="hidden" class="card-expiry-month required form-control" name="card-expiry-month" />
                                                        <input type="hidden" class="card-expiry-year required form-control" name="card-expiry-year" />
                                                    </div>

                                                    <div class="col-lg-6 pl-0">
                                                        <input type="text" class="card-cvc required form-control" title="please input only number." pattern="[0-9]{3}" name="card-cvc" placeholder="CVC" title="CVC" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{__('Name on card')}}</label>
                                                <input type="text" class="required form-control" name="name" title="Name on Card" required />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary mt-4 btn-submit" value="Pay" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card hide cod_card">
                            <div class="card-header">
                                <strong>{{__('Cash on delivery')}}</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <input type="button" onclick="purchase()" value="{{__('pay with COD')}}" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card paystack_card hide">
                            <div class="card-header">
                                <strong>{{__('Paystack')}}</strong>
                            </div>
                            <div class="card-body">
                                <form id="paymentForm">
                                    <input type="hidden" id="paystack-public-key" value="{{ App\Models\Setting::find(1)->paystack_public_key }}">
                                    <input type="hidden" id="email-address" value="{{ auth()->user()->email }}" required />
                                    <div class="form-submit text-center">
                                        <input type="button" class="btn btn-primary" onclick="payWithPaystack()" value="{{__('Pay with paystack')}}">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card flutterwave_card hide">
                            <div class="card-header">
                                <strong>{{__('Flutterwave')}}</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <input type="button" onclick="flutterwave()" value="{{__('pay with flutterwave')}}" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
    <script src="{{ url('payment/stripe.js')}}"></script>

    <script src="{{ url('assets_admin/js/subscription.js') }}"></script>

    <script src="https://www.paypal.com/sdk/js?client-id={{ App\Models\Setting::first()->paypal_client_id }}&currency={{ App\Models\Setting::first()->currency_code }}" data-namespace="paypal_sdk"></script>

    <script src="{{ url('payment/razorpay.js')}}"></script>

    @if(App\Models\Setting::first()->paystack_public_key)
    <script src="https://js.paystack.co/v2/inline.js"></script>
    @endif
@endsection

@endsection

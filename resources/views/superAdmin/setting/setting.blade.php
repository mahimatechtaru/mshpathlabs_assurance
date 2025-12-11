@extends('layout.mainlayout_admin',['activePage' => 'setting'])

@section('title',__('Admin Setting'))

@section('setting')

<section class="section">
    @include('layout.breadcrumb',[
    'title' => __('Setting'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
    'status' => session('status')])
    @endif
    @if (session('error_msg'))
    @include('superAdmin.auth.status',[
    'status' => session('error_msg')])
    @endif

    @if($errors->any())
    @foreach ($errors->all() as $error)
        @include('superAdmin.auth.status',[
        'status' => $error, 'icon' => 'warning'])
    @endforeach
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        @if($setting->license_verify == 1)
                        <li class="nav-item"><a class="nav-link active" href="#solid-justified-tab1" data-toggle="tab">{{__('General Settings')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab2" data-toggle="tab">{{__('Payment setting')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab3" data-toggle="tab">{{__('verification')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab5" data-toggle="tab">{{__('Website Setting')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab6" data-toggle="tab">{{__('Notification Setting')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab8" data-toggle="tab">{{__('Static Pages')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab9" data-toggle="tab">{{__('Video Call Setting')}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-justified-tab10" data-toggle="tab">{{__('Zoom Integration')}}</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link {{ $setting->license_verify == 0 ? 'active' : ''  }}" href="#solid-justified-tab7" data-toggle="tab">{{__('License Setting')}}</a></li>
                    </ul>
                    <div class="tab-content mt-3">
                        @if($setting->license_verify == 1)
                        <div class="tab-pane show active" id="solid-justified-tab1">
                            <form action="{{url('update_general_setting')}}" method="POST" enctype="multipart/form-data" class="myform">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="app_id" class="ul-form__label"> {{__('Company white logo')}}</label>
                                        <div class="avatar-upload avatar-box avatar-box-left">
                                            <div class="avatar-edit">
                                                <input type='file' id="image" name="company_white_logo" accept=".png, .jpg, .jpeg" />
                                                <label for="image"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview" style="background-image: url({{ $setting->companyWhite }});"></div>
                                            </div>
                                        </div>
                                        @error('company_white_logo')
                                        <div class="custom_error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="app_id" class="col-form-label"> {{__('Company logo')}}</label>
                                        <div class="avatar-upload avatar-box avatar-box-left">
                                            <div class="avatar-edit">
                                                <input type='file' id="image2" name="company_logo" accept=".png, .jpg, .jpeg" />
                                                <label for="image2"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview2" style="background-image: url({{ $setting->logo }});"></div>
                                            </div>
                                        </div>
                                        @error('company_logo')
                                        <div class="custom_error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="app_id" class="col-form-label"> {{__('Company favicon')}}</label>
                                        <div class="avatar-upload avatar-box avatar-box-left">
                                            <div class="avatar-edit">
                                                <input type='file' id="image3" name="company_favicon" accept=".png, .jpg, .jpeg" />
                                                <label for="image3"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview3" style="background-image: url({{ $setting->favicon }});"></div>
                                            </div>
                                        </div>
                                        @error('company_favicon')
                                        <div class="custom_error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-4 form-group">
                                        <label for="business_name" class="col-form-label"> {{__('Business Name')}}</label>
                                        <input type="text" required name="business_name" value="{{ $setting->business_name }}" class="form-control @error('business_name') is-invalid @enderror">
                                        @error('business_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="email" class="col-form-label"> {{__('Email')}}</label>
                                        <input type="email" required name="email" value="{{ $setting->email }}" class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="phone" class="col-form-label"> {{__('Phone number')}}</label>
                                        <input type="number" min="1" required name="phone" value="{{ $setting->phone }}" class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-6 form-group">
                                        <label for="app_id" class="col-form-label"> {{__('Admin Color')}}</label>
                                        <input type="color" required value="{{ $setting->color }}" name="color" class="form-control @error('color') is-invalid @enderror">
                                        @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="app_id" class="col-form-label"> {{__('Website Color')}}</label>
                                        <input type="color" required value="{{ $setting->website_color }}" name="website_color" class="form-control @error('website_color') is-invalid @enderror">
                                        @error('website_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="app_id" class="col-form-label"> {{__('Order Cancel Thresold By Doctor(In Minutes)')}}</label>
                                    <input type="number" min=1 required value="{{ $setting->auto_cancel }}" name="auto_cancel" class="form-control @error('auto_cancel') is-invalid @enderror">
                                    @error('auto_cancel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-6 form-group">
                                        <label for="app_id" class="col-form-label"> {{__('Timezone')}}</label>
                                        <select name="timezone" class="select2">
                                            @foreach ($timezones as $timezone)
                                            <option value="{{ $timezone->TimeZone }}" {{ $timezone->TimeZone == $setting->timezone ? 'selected' : '' }}>
                                                {{ $timezone->UTC_DST_offset }}&nbsp;&nbsp;{{ $timezone->TimeZone }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="app_id" class="col-form-label"> {{__('Currency')}}</label>
                                        <select name="currency_code" class="select2">
                                            @foreach ($currencies as $currency)
                                            <option value="{{$currency->id}}" {{ $currency->id == $setting->currency_id ? 'selected' : ''}}>
                                                {{$currency->country}}&nbsp;&nbsp;({{$currency->currency}})&nbsp;&nbsp;({{$currency->code}})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-6 form-group">
                                        <label for="radius" class="col-form-label"> {{__("Radius")}}</label>
                                        <input type="number" min="1" name="radius" class="radius form-control" value="{{ $setting->radius }}">
                                        @error('radius')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="language" class="col-form-label"> {{__("Language")}}</label>
                                        <select name="language" class="form-control">
                                            @foreach ($languages as $language)
                                            <option value="{{ $language->name }}" {{ $setting->language == $language->name ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="default_base_on" class="col-form-label"> {{__("doctor register with app it's based on commission or subscription?")}}</label>
                                    <select name="default_base_on" class="form-control">
                                        <option value="subscription" {{ $setting->default_base_on == 'subscription' ? 'selected' : ''}}>{{__('subscription')}}</option>
                                        <option value="commission" {{ $setting->default_base_on == 'commission' ? 'selected' : ''}}>{{__('commission')}}</option>
                                    </select>
                                    @error('default_base_on')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="pharmacy_commission" class="col-form-label">{{__("pharmacy admin register with app it's commission ?")}}</label>
                                        <input type="number" min="1" name="pharmacy_commission" required value="{{ $setting->pharmacy_commission }}" class="form-control @error('pharmacy_commission') is-invalid @enderror">
                                        @error('pharmacy_commission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="pathologist_commission" class="col-form-label">{{__("pathologist register with app it's commission ?")}}</label>
                                        <input type="number" min="1" name="pathologist_commission" required value="{{ $setting->pathologist_commission }}" class="form-control @error('pathologist_commission') is-invalid @enderror">
                                        @error('pathologist_commission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <div class="form-group default_base_on_com {{$setting->default_base_on != 'commission' ? 'hide' : ''}}">
                                            <label for="default_commission" class="col-form-label"> {{__("commission (in %)")}}</label>
                                            <input type="number" min="1" name="default_commission" {{$setting->default_base_on == 'commission' ? 'required' : ''}} value="{{ $setting->default_commission }}" class="form-control @error('default_commission') is-invalid @enderror default_base_on_com_text">
                                            @error('default_commission')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <div class="form-group">
                                            <label for="map_key" class="col-form-label"> {{__('Google map key')}}</label>
                                            <a href="https://developers.google.com/maps/documentation" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </a>
                                            <input type="text" required name="map_key" value="{{ $setting->map_key }}" class="form-control @error('map_key') is-invalid @enderror">
                                            @error('map_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="address" class="col-form-label">{{__("Search for the location")}}</label>
                                        <input id="pac-input" type="text" name="address" class="form-control" placeholder="{{__('Location')}}" />
                                    </div>
                                    <div class="col-lg-12">
                                        <div id="map" class="mapClass"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="lat" class="col-form-label">{{__("Latitude")}}</label>
                                        <input type="text" name="lat" required value="{{ $setting->lat }}" id="lat" class="form-control @error('lat') is-invalid @enderror">
                                        @error('lat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="lang" class="col-form-label">{{__("Longitude")}}</label>
                                        <input type="text" name="lang" required value="{{ $setting->lang }}" id="lng" class="form-control @error('lang') is-invalid @enderror">
                                        @error('lang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <table class="table table-bordered cancel_reason">
                                        <thead>
                                            <tr>
                                                <td> {{__('Add reason')}} </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" onclick="add_cancel_reason()">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($setting->cancel_reason != null)
                                            @php
                                            $cancel_reasons = json_decode($setting->cancel_reason)
                                            @endphp
                                            @foreach ($cancel_reasons as $cancel_reason)
                                            <tr>
                                                <td>
                                                    <input type="text" name="cancel_reason[]" value="{{ $cancel_reason }}" class="form-control" required>
                                                </td>
                                                @if ($loop->iteration != 1)
                                                <td>
                                                    <button type="button" class="btn btn-danger removebtn"><i class="fas fa-times"></i></button>
                                                </td>
                                                @endif
                                            </tr>

                                            @endforeach
                                            @else
                                            <tr>
                                                <td>
                                                    <input type="text" name="cancel_reason[]" class="form-control" required>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-12 text-center">
                                        <input type="submit" class="btn btn-primary" value="{{__('Submit')}}">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="solid-justified-tab2">
                            <form action="{{url('update_payment_setting')}}" method="POST" enctype="multipart/form-data" class="myform">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="col-form-label">{{__('COD')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="cod" class="custom-switch-input" value="1" {{ $setting->cod == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label">{{__('PAYPAL')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="paypal" class="custom-switch-input" value="1" {{ $setting->paypal == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label">{{__('STRIPE')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="stripe" class="custom-switch-input" value="1" {{ $setting->stripe == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label">{{__('RAZORPAY')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="razor" class="custom-switch-input" value="1" {{$setting->razor == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label">{{__('Flutterwave')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="flutterwave" class="custom-switch-input" value="1" {{ $setting->flutterwave == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label">{{__('PAYSTACK')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="paystack" class="custom-switch-input" value="1" {{ $setting->paystack == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Stripe public key')}}</label>
                                    <a href="https://stripe.com/docs/keys#obtain-api-keys" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->stripe_public_key }}" name="stripe_public_key" class="hide_value form-control @error('stripe_public_key') is-invalid @enderror">
                                    @error('stripe_public_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Stripe secret key')}}</label>
                                    <input type="text" value="{{ $setting->stripe_secret_key }}" name="stripe_secret_key" class="hide_value form-control @error('stripe_secret_key') is-invalid @enderror">
                                    @error('stripe_secret_key')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Paypal client ID (either Sandbox or Live)')}}</label>
                                    <a href="https://www.appinvoice.com/en/s/documentation/how-to-get-paypal-client-id-and-secret-key-22" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->paypal_client_id }}" name="paypal_client_id" class="hide_value form-control @error('paypal_client_id') is-invalid @enderror">
                                    @error('paypal_client_id')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('paypal Secret key (either Sandbox or Live)')}}</label>
                                    <input type="text" value="{{ $setting->paypal_secret_key }}" name="paypal_secret_key" class="hide_value form-control @error('paypal_secret_key') is-invalid @enderror">
                                    @error('paypal_secret_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Razorpay key')}}</label>
                                    <a href="https://razorpay.com/docs/payments/dashboard/settings/api-keys/" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->razor_key }}" name="razor_key" class="hide_value form-control @error('razor_key') is-invalid @enderror">
                                    @error('razor_key')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Flutterwave Key')}}</label>
                                    <a href="https://developer.flutterwave.com/docs/quickstart/" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->flutterwave_key }}" name="flutterwave_key" class="hide_value form-control @error('flutterwave_key') is-invalid @enderror">
                                    @error('flutterwave_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Flutterwave Encryption Key')}}</label>
                                    <input type="text" value="{{ $setting->flutterwave_encryption_key }}" name="flutterwave_encryption_key" class="hide_value form-control @error('flutterwave_encryption_key') is-invalid @enderror">
                                    @error('flutterwave_encryption_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Is Live Key?')}}</label>
                                    <select name="isLiveKey" class="form-control">
                                        <option value="1" {{ $setting->isLiveKey == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                        <option value="0" {{ $setting->isLiveKey == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                                    </select>
                                    @error('flutterwave_encryption_key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Paystack Key')}}</label>
                                    <a href="https://support.paystack.com/hc/en-us/articles/360011508199-How-do-I-generate-new-API-keys" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->paystack_public_key }}" name="paystack_public_key" class="hide_value form-control @error('paystack_public_key') is-invalid @enderror">
                                    @error('paystack_public_key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12 text-right">
                                        <input type="submit" value="{{__('submit')}}" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="solid-justified-tab3">
                            <form action="{{url('update_verification_setting')}}" method="POST" enctype="multipart/form-data" class="myform">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="col-form-label">{{__('User and doctor verification')}}</label>
                                        <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('Verification Global Switch') }}"></i>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="verification" class="custom-switch-input" value="1" {{ $setting->verification == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="col-form-label">{{__('Verification using email ?')}}</label>
                                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('Choose either email or message for verification') }}"></i>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="verification_method" class="custom-switch-input" value="email" {{ $setting->using_mail == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="col-form-label">{{__('Verification using message ?')}}</label>
                                        <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('Choose either email or message for verification') }}"></i>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="verification_method" class="custom-switch-input" value="sms" {{ $setting->using_msg == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Twilio auth token')}}</label>
                                    <a href="https://www.twilio.com/docs/glossary/what-is-an-api-key" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->twilio_auth_token }}" name="twilio_auth_token" class="hide_value form-control @error('twilio_auth_token') is-invalid @enderror">
                                    @error('twilio_auth_token')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('twilio account id')}}</label>
                                    <input type="text" value="{{ $setting->twilio_acc_id }}" name="twilio_acc_id" class="hide_value form-control @error('twilio_acc_id') is-invalid @enderror">
                                    @error('twilio_acc_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('twilio phone number')}}</label>
                                    <input type="text" value="{{ $setting->twilio_phone_no }}" name="twilio_phone_no" class="hide_value form-control @error('twilio_phone_no') is-invalid @enderror">
                                    @error('twilio_phone_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail mailer')}}</label>
                                    <a href="https://sendgrid.com/blog/what-is-an-smtp-server/" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->mail_mailer }}" name="mail_mailer" class="hide_value form-control @error('mail_mailer') is-invalid @enderror">
                                    @error('mail_mailer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail host')}}</label>
                                    <input type="text" value="{{ $setting->mail_host }}" name="mail_host" class="hide_value form-control @error('mail_host') is-invalid @enderror">
                                    @error('mail_host')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail port')}}</label>
                                    <input type="text" value="{{ $setting->mail_port }}" name="mail_port" class="hide_value form-control @error('mail_port') is-invalid @enderror">
                                    @error('mail_port')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail username')}}</label>
                                    <input type="text" value="{{ $setting->mail_username }}" name="mail_username" class="hide_value form-control @error('mail_username') is-invalid @enderror">
                                    @error('mail_username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail password')}}</label>
                                    <input type="text" value="{{ $setting->mail_password }}" name="mail_password" class="hide_value form-control @error('mail_password') is-invalid @enderror">
                                    @error('mail_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail encryption')}}</label>
                                    <select name="mail_encryption" class="hide_value form-control @error('mail_encryption') is-invalid @enderror">
                                        <option value="ssl" {{ $setting->mail_encryption == 'ssl' ? 'selected' : '' }}>ssl</option>
                                        <option value="tls" {{ $setting->mail_encryption == 'tls' ? 'selected' : '' }}>tls</option>
                                    </select>
                                    @error('mail_encryption')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail from address')}}</label>
                                    <input type="text" value="{{ $setting->mail_from_address }}" name="mail_from_address" class="hide_value form-control @error('mail_from_address') is-invalid @enderror">
                                    @error('mail_from_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('mail from name')}}</label>
                                    <input type="text" value="{{ $setting->mail_from_name }}" name="mail_from_name" class="hide_value form-control @error('mail_from_name') is-invalid @enderror">
                                    @error('mail_from_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="row mt-4">
                                    <div class="div text-right">
                                        <input type="submit" value="{{__('submit')}}" class="btn btn-primary">
                                    </div>
                                    <div class="div text-left mx-1">
                                        <input type="button" value="{{__('Test Mail')}}" data-toggle="modal" data-target="#exampleModalCenter" class=" btn btn-primary ">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="solid-justified-tab5">
                            <form action="{{url('update_content')}}" method="POST" enctype="multipart/form-data" class="myform">
                                @csrf

                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="app_id" class="col-form-label"> {{__('Website Banner Image')}}</label>
                                        <div class="avatar-upload avatar-box avatar-box-left">
                                            <div class="avatar-edit">
                                                <input type='file' id="image4" name="banner_image" accept=".png, .jpg, .jpeg" />
                                                <label for="image4"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview4" style="background-image: url({{ 'images/upload/'.$setting->banner_image }});"></div>
                                            </div>
                                        </div>
                                        @error('banner_image')
                                        <div class="custom_error">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Banner URL')}}</label>
                                            <input type="text" name="banner_url" required class="form-control @error('banner_url') is-invalid @enderror" value="{{ $setting->banner_url }}">
                                            @error('banner_url')
                                            <div class="invalid-feedback"> {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">{{__('Landing Page Pop-up')}}</label>
                                        <input type="file" name="landing_popup_image" id="popup_image" class="form-control @error('landing_popup_image') is-invalid @enderror landing_popup_image" value="{{ $setting->landing_popup_image }}">
                                        @error('landing_popup_image')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">{{__('Show Popup after X Seconds')}}</label>
                                        <input type="number" name="popup_timer_seconds" id="popup_timer_seconds" class="form-control @error('popup_timer_seconds') is-invalid @enderror popup_timer_seconds" value="{{ $setting->popup_timer_seconds }}">
                                        @error('popup_timer_seconds')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('PopUp Redirection URL')}}</label>
                                    <input type="url" name="popup_target_url" class="form-control @error('popup_target_url') is-invalid @enderror" value="{{ $setting->popup_target_url }}">
                                    @error('popup_target_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Popup Switch')}}</label>
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="landing_popup_switch" class="custom-switch-input" value="1" {{ $setting->landing_popup_switch == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Play Store URL')}}</label>
                                    <input type="url" name="playstore" required class="form-control @error('playstore') is-invalid @enderror" value="{{ $setting->playstore }}">
                                    @error('playstore')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('App Store URL')}}</label>
                                    <input type="url" name="appstore" required class="form-control @error('appstore') is-invalid @enderror" value="{{ $setting->appstore }}">
                                    @error('appstore')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Facebook url')}}</label>
                                    <input type="url" name="facebook_url" required class="form-control @error('facebook_url') is-invalid @enderror" value="{{ $setting->facebook_url }}">
                                    @error('facebook_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Twitter url')}}</label>
                                    <input type="url" name="twitter_url" required class="form-control @error('twitter_url') is-invalid @enderror" value="{{ $setting->twitter_url }}">
                                    @error('twitter_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Instagram url')}}</label>
                                    <input type="url" name="instagram_url" required class="form-control @error('instagram_url') is-invalid @enderror" value="{{ $setting->instagram_url }}">
                                    @error('instagram_url')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('Linkdin url')}}</label>
                                    <input type="url" name="linkdin_url" required class="form-control @error('linkdin_url') is-invalid @enderror" value="{{ $setting->linkdin_url }}">
                                    @error('linkdin_url')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-5">{{__('save')}}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="solid-justified-tab6">
                            <form action="{{url('update_notification')}}" method="POST" class="myform">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">{{__('Send Mail To Patient?')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="patient_mail" class="custom-switch-input" value="1" {{ $setting->patient_mail == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">{{__('Send Mail To Doctor?')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="doctor_mail" class="custom-switch-input" value="1" {{ $setting->doctor_mail == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">{{__('Send Push Notification To Patient?')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="patient_notification" class="custom-switch-input" value="1" {{ $setting->patient_notification
                                            == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">{{__('Send Push Notification To Doctor?')}}</label>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="doctor_notification" class="custom-switch-input" value="1" {{ $setting->doctor_notification == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <label class="mt-5 text-primary" class="col-form-label">{{__('For Patient :: ')}}</label>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('App ID')}}</label>
                                    <a href="https://documentation.onesignal.com/docs/accounts-and-keys" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->patient_app_id }}" name="patient_app_id" class="hide_value form-control @error('patient_app_id') is-invalid @enderror">
                                    @error('patient_app_id')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Auth key')}}</label>
                                    <input type="text" value="{{ $setting->patient_auth_key }}" name="patient_auth_key" class="hide_value form-control @error('patient_auth_key') is-invalid @enderror">
                                    @error('patient_auth_key')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('API key')}}</label>
                                    <input type="text" value="{{ $setting->patient_api_key }}" name="patient_api_key" class="hide_value form-control @error('patient_api_key') is-invalid @enderror">
                                    @error('patient_api_key')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <label class="mt-5 text-primary" class="col-form-label">{{__('For Doctor :: ')}}</label>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('App ID')}}</label>
                                    <a href="https://documentation.onesignal.com/docs/accounts-and-keys" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input type="text" value="{{ $setting->doctor_app_id }}" name="doctor_app_id" class="hide_value form-control @error('doctor_app_id') is-invalid @enderror">
                                    @error('doctor_app_id')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Auth key')}}</label>
                                    <input type="text" value="{{ $setting->doctor_auth_key }}" name="doctor_auth_key" class="hide_value form-control @error('doctor_auth_key') is-invalid @enderror">
                                    @error('doctor_auth_key')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">{{__('API key')}}</label>
                                    <input type="text" value="{{ $setting->doctor_api_key }}" name="doctor_api_key" class="hide_value form-control @error('doctor_api_key') is-invalid @enderror">
                                    @error('doctor_api_key')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-5">{{__('save')}}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="solid-justified-tab8">
                            <form action="{{url('update_static_page')}}" method="POST" class="myform">
                                @csrf
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Privacy Policy')}}</label>
                                    <textarea name="privacy_policy" class="form-control summernote @error('privacy_policy') is-invalid @enderror">{{ $setting->privacy_policy }}</textarea>
                                    @error('privacy_policy')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('About Us')}}</label>
                                    <textarea name="about_us" class="form-control summernote @error('about_us') is-invalid @enderror">{{ $setting->about_us }}</textarea>
                                    @error('about_us')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Home Content')}}</label>
                                    <input name="home_content" class="form-control @error('home_content') is-invalid @enderror" value=" {{$setting->home_content }}">
                                    @error('home_content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Home Content Description')}}</label>
                                    <textarea name="home_content_desc" class="form-control summernote @error('home_content_desc') is-invalid @enderror">{{ $setting->home_content_desc }}</textarea>
                                    @error('home_content_desc')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-5">{{__('save')}}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="solid-justified-tab9">
                            <form action="{{url('update_video_call_setting')}}" method="POST" class="myform">
                                @csrf
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Agora App Id')}}</label>
                                    <a href="https://docs.agora.io/en/voice-calling/reference/manage-agora-account?platform=android" target="_blank" class="" data-toggle="tooltip" data-placement="top" title="Help">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                    <input name="agora_app_id" class="hide_value form-control @error('agora_app_id') is-invalid @enderror" value="{{ $setting->agora_app_id }}">
                                    @error('agora_app_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Agora App Certificate')}}</label>
                                    <input name="agora_app_certificate" class="hide_value form-control @error('agora_app_certificate') is-invalid @enderror" value="{{ $setting->agora_app_certificate }}">
                                    @error('agora_app_certificate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-5">{{__('save')}}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="solid-justified-tab10">
                            <form action="{{url('update_zoom_setting')}}" method="POST" class="myform">
                                @csrf
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Zoom Switch')}}</label>
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="zoom_switch" class="custom-switch-input" id="zoom_switch" value="1" {{ $setting->zoom_switch == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Zoom Client ID')}}</label>
                                    <span data-toggle="tooltip" data-placement="top" title="{{__('Steps are mentioned in the provided documentation')}}">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" name="zoom_client_id" class="hide_value form-control @error('zoom_client_id') is-invalid @enderror" value="{{ $setting->zoom_client_id }}">
                                    @error('zoom_client_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Zoom Client Secret')}}</label>
                                    <input type="text" name="zoom_client_secret" class="hide_value form-control @error('zoom_client_secret') is-invalid @enderror" value="{{ $setting->zoom_client_secret }}">
                                    @error('zoom_client_secret')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Zoom Redirect URL')}}</label>
                                    <input type="url" name="zoom_redirect_url" class="hide_value form-control @error('zoom_redirect_url') is-invalid @enderror" value="{{ $setting->zoom_redirect_url }}" placeholder="https://YOUR-DOMAIN.XYZ/zoom-oauth-callback">
                                    @error('zoom_redirect_url')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Zoom Page Content (optional)')}}</label>
                                    <br>
                                    <span>{{ __('Enter Zoom details as per your Website & Brand, link will be there in the website footer. This will be required while making the zoom feature accessible for live users.') }}</span>
                                    <textarea name="zoom_page_content" class="form-control summernote @error('zoom_page_content') is-invalid @enderror">{{ $setting->zoom_page_content }}</textarea>
                                    @error('zoom_page_content')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-5">{{__('save')}}</button>
                                </div>
                            </form>
                        </div>
                        @endif

                        <div class="tab-pane {{ $setting->license_verify == 0 ? ' show active' : ''  }}" id="solid-justified-tab7">
                            <form action="{{url('update_licence_setting')}}" method="POST" class="myform">
                                @csrf
                                <div class="form-group">
                                    <label class="col-form-label">{{__('License Code')}}</label>
                                    <input type="text" required {{ $setting->license_verify == 1 ? 'disabled' : '' }} value="{{ $setting->license_code }}" name="license_code" class="hide_value form-control
                                    @error('license_code') is-invalid @enderror">
                                    @error('license_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Client Name')}}</label>
                                    <input type="text" required {{ $setting->license_verify == 1 ? 'disabled' : '' }} value="{{ $setting->client_name }}" name="client_name" class="hide_value form-control
                                    @error('client_name') is-invalid @enderror">
                                    @error('client_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" {{ $setting->license_verify == 1 ? 'disabled' : '' }} class="btn btn-primary mt-5">{{__('save')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{__('Test Mail')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="col-form-label">{{__('Recipient Email for SMTP Testing')}}</label>
                <input type="text" name="mail_to" id="to" value="{{auth()->user()->email}}" required class="form-control @error('mail_to') is-invalid @enderror">
                <span class="text-danger" id="validate"></span>
                @error('mail_to')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary" id="TestMail" onclick="testMail()">{{__('Send')}}</button>
            </div>
            <div class="emailstatus text-right mr-3"></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        function readURL4(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview4').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview4').hide();
                    $('#imagePreview4').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image4").change(function() {
            readURL4(this);
        });
        $('#zoom_switch').change(function() {
            if($(this).is(':checked')) {
                $('#zoom_client_id').attr('required', true);
                $('#zoom_client_secret').attr('required', true);
                $('#zoom_redirect_url').attr('required', true);
            } else {
                $('#zoom_client_id').removeAttr('required');
                $('#zoom_client_secret').removeAttr('required');
                $('#zoom_redirect_url').removeAttr('required');
            }
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
<script src="{{ url('assets_admin/js/hospital_map.js') }}"></script>
@endsection

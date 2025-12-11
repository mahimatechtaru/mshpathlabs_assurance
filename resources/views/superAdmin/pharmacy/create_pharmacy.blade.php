@extends('layout.mainlayout_admin',['activePage' => 'pharmacy'])

@section('title',__('Add pharmacy'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Pharmacy'),
        'url' => url('pharmacy'),
        'urlTitle' => __('Pharmacy')
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
    <form action="{{ url('pharmacy') }}" method="post" enctype="multipart/form-data" class="myform">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-4">
                            <label for="pharmacy_image" class="col-form-label"> {{__('pharmacy image')}}</label>
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
                        <div class="col-lg-10 col-md-8">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Name')}}</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('Email')}}</label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label for="phone_number" class="ul-form__label"> {{__('Phone number')}}</label>
                        <div class="d-flex @error('phone') is-invalid @enderror">
                            <select name="phone_code" class="phone_code_select2" >
                                @foreach ($countries as $country)
                                    {{-- <option value="+{{$country->phonecode}}">+{{ $country->phonecode }}</option> --}}
                                    <option value="+{{$country->phonecode}}" {{(old('phone_code') == $country->phonecode) ? 'selected':''}}>+{{ $country->phonecode }}</option>
                                @endforeach
                            </select>
                            <input type="number" min="1" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Start Time')}}</label>
                            <input class="form-control timepicker @error('start_time') is-invalid @enderror" name="start_time" value="{{old('start_time')}}" type="time">
                            @error('start_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('End Time')}}</label>
                            <input class="form-control timepicker @error('end_time') is-invalid @enderror" name="end_time" value="{{old('end_time')}}" type="time">
                            @error('end_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Commission Amount')}}({{__('in %')}})</label>
                        <input type="number" min="1" step="any" class="form-control @error('commission_amount') is-invalid @enderror" name="commission_amount" value="{{ old('commission_amount') }}">
                        @error('commission_amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Description')}}</label>
                        <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror" >{{old('description')}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row mt-4">
                        <div class="pac-card col-md-12 mb-3" id="pac-card">
                            <label for="pac-input">{{__('Location based on latitude/longtitude')}}</label>
                            <div id="pac-container">
                                <input id="pac-input" type="text" name="address" class="form-control" value="{{ old('address') }}"/>
                                <input type="hidden" name="lat" value="{{$setting->lat}}" id="lat">
                                <input type="hidden" name="lang" value="{{$setting->lang}}" id="lng">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div id="map" class="mapClass"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Allow Shipping ??')}}</label>
                        <label class="cursor-pointer ml-2">
                            <input type="checkbox" id="is_shipping" class="custom-switch-input" name="is_shipping">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="row mt-4 deliveryChargeDiv hide">
                        <div class="col-lg-12">
                            <table class="table mt-2 delivery_charge_table">
                                <thead class="font-bold">{{__("delivery charge")}}</thead>
                                <tbody>
                                    <tr>
                                        <td>{{__('Distance From')}}</td>
                                        <td>{{__('Distance To')}}</td>
                                        <td>{{__('Charges')}}({{$currency}})</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input type="number" min="1" name="min_value[]" class="form-control min_value"></td>
                                        <td><input type="number" min="1" name="max_value[]" class="form-control max_value"></td>
                                        <td><input type="number" min="1" name="charges[]" class="form-control charges"></td>
                                        <td><button type="button" class="btn btn-primary" onclick="addCharge()"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="text-right m-4">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('js')
    <script src="{{ url('assets_admin/js/hospital_map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
@endsection

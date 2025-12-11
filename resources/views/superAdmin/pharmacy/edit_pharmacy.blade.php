@extends('layout.mainlayout_admin',['activePage' => 'pharmacy'])

@section('title',__('Edit pharmacy'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Pharmacy'),
        'url' => url('pharmacy'),
        'urlTitle' => __('Pharmacy')
    ])

    <div class="section_body">
     <form action="{{ url('pharmacy/'.$pharmacy->id) }}" method="post" enctype="multipart/form-data" class="myform">
            @csrf
            @method('PUT')
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
                                    <div id="imagePreview" style="background-image: url({{ $pharmacy->fullImage }});">
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
                                <input type="text" value="{{ old('name',$pharmacy->name) }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('Email')}}</label>
                                <input type="email" readonly value="{{ old('email',$pharmacy->email) }}" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-form-label">{{__('Phone number')}}</label>
                        <input type="email" readonly value="{{ old('phone',$pharmacy->phone) }}" name="phone" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Start Time')}}</label>
                            <input class="form-control timepicker @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time',$pharmacy->start_time) }}" type="time">
                            @error('start_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('End Time')}}</label>
                            <input class="form-control timepicker @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time',$pharmacy->end_time) }}" type="time">
                            @error('end_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Commission Amount')}}({{__('in %')}})</label>
                        <input type="number" min="1" step="any" class="form-control @error('commission_amount') is-invalid @enderror" name="commission_amount" value="{{ old('commission_amount',$pharmacy->commission_amount) }}">
                        @error('commission_amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Description')}}</label>
                        <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror">{{ old('description',$pharmacy->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row mt-4">
                        <div class="pac-card col-md-12 mb-3" id="pac-card">
                            <label for="pac-input form-group">{{__('Location based on latitude/longtitude')}}</label>
                            <div id="pac-container">
                                <input id="pac-input" type="text" value="{{$pharmacy->address}}" name="address" class="form-control" value="{{ old('address',$pharmacy->address) }}"/>
                                <input type="hidden" name="lat" value="{{$pharmacy->lat}}" id="lat">
                                <input type="hidden" name="lang" value="{{$pharmacy->lang}}" id="lng">
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
                        <label class="col-form-label">{{__('Allow Shipping ?')}}</label>
                        <label class="cursor-pointer ml-2">
                            <input type="checkbox" id="is_shipping" class="custom-switch-input" name="is_shipping" {{ $pharmacy->is_shipping == 1 ? 'checked' : "" }}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="row mt-4 deliveryChargeDiv {{ $pharmacy->is_shipping != 1 ? 'hide' : '' }}">
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
                                    @php
                                        $delivery_charge = json_decode($pharmacy->delivery_charges);
                                    @endphp
                                    @if ($delivery_charge != null)
                                        @foreach ($delivery_charge as $delivery_charge)
                                            <tr>
                                                <td><input type="number" min="1" name="min_value[]" value="{{ $delivery_charge->min_value }}" class="form-control min_value"></td>
                                                <td><input type="number" min="1" name="max_value[]" value="{{ $delivery_charge->max_value }}" class="form-control max_value"></td>
                                                <td><input type="number" min="1" name="charges[]" value="{{ $delivery_charge->charges }}" class="form-control charges"></td>
                                                @if ($loop->iteration == 1)
                                                    <td><button type="button" class="btn btn-primary" onclick="addCharge()"><i class="fas fa-plus"></i></button></td>
                                                @else
                                                    <td><button type="button" class="btn btn-danger removebtn"><i class="fas fa-times"></i></button></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td><input type="number" min="1" name="min_value[]" class="form-control min_value"></td>
                                            <td><input type="number" min="1" name="max_value[]" class="form-control max_value"></td>
                                            <td><input type="number" min="1" name="charges[]" class="form-control charges"></td>
                                            <td><button type="button" class="btn btn-primary" onclick="addCharge()"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                    @endif
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
@endsection

@section('js')
    <script src="{{ url('assets_admin/js/hospital_map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
@endsection

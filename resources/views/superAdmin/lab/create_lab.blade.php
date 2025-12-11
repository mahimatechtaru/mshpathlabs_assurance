@extends('layout.mainlayout_admin',['activePage' => 'lab'])

@section('title',__('Add Laboratory'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Laboratory'),
        'url' => url('laboratory'),
        'urlTitle' => __('Laboratory'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('laboratory') }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <label for="lab_image" class="col-form-label"> {{__('Laboratory image')}}</label>
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
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">{{__('Laboratory Name')}}</label>
                            <input type="text" required value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6 form-group">
                                <label for="phone_number" class="col-form-label"> {{__('Phone number')}}</label>
                                <div class="d-flex @error('phone') is-invalid @enderror">
                                    <select name="phone_code" class="phone_code_select2">
                                        @foreach ($countries as $country)
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
                            <div class="col-lg-6 form-group">
                                <label for="email" class="col-form-label"> {{__('Email')}}</label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 form-group">
                                <label class="col-form-label">{{__('Start Time')}}</label>
                                <input class="form-control timepicker @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time') }}" type="time">
                                @error('start_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="col-form-label">{{__('End Time')}}</label>
                                <input class="form-control timepicker @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time') }}" type="time">
                                @error('end_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">{{__('Commission')}}({{ __('In Percantage') }})</label>
                            <input class="form-control @error('commission') is-invalid @enderror" name="commission" value="{{ old('commission') }}" type="number" min="1">
                            @error('commission')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mt-4">
                            <div class="pac-card col-md-12 mb-3" id="pac-card">
                                <label for="pac-input col-form-label">{{__('Location based on latitude/longitude')}}</label>
                                <div id="pac-container">
                                    <input id="pac-input" type="text" name="address" class="form-control @error('address') is-invalid @enderror" />
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="hidden" name="lat" value="{{$setting->lat}}" id="lat">
                                    <input type="hidden" name="lng" value="{{$setting->lang}}" id="lng">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="map" class="mapClass"></div>
                            </div>
                        </div>
                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@section('js')
    <script src="{{ url('assets_admin/js/hospital_map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
@endsection

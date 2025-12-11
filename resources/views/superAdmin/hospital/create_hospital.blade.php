@extends('layout.mainlayout_admin',['activePage' => 'hospital'])

@section('title',__('Add hospital'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add hospital'),
        'url' => url('hospital'),
        'urlTitle' => __('Hospital'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('hospital') }}" method="post" class="myform">
                @csrf
                <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label">{{__('Hospital Name')}}</label>
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">{{__('Phone number')}}</label>
                            <input type="number" min="1" value="{{ old('phone') }}" name="phone" class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">{{__('Hospital Facility')}}</label>
                            <input type="text" data-role="tagsinput" class="input-tags form-control @error('facility') is-invalid @enderror" name="facility" id="facility">
                            @error('facility')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="row mt-4">
                            <div class="pac-card col-md-12 mb-3" id="pac-card">
                                <label for="pac-input col-form-label">{{__('Location based on latitude/longitude')}}</label>
                                <div id="pac-container">
                                    <input id="pac-input" type="text" name="address" class="form-control" />
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

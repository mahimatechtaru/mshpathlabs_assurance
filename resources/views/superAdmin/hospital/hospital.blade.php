@extends('layout.mainlayout_admin',['activePage' => 'hospital'])

@section('title',__('All Hospital'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('hospital'),
    ])
    <div class="section_body">
        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif
        <div class="card">
            <div class="card-body">
                <div id="hospitals-map" style="width: 100%; height: 300px;"></div>
                <script defer
                    src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\Setting::select('map_key')->first()->map_key }}&callback=initMap&loading=async">
                </script>
                <script>
                    function initMap() {
                        var locations = @json($hospitals);
                        var center = {
                            lat: locations.length ? locations.reduce((sum, loc) => sum + parseFloat(loc.lat), 0) / locations.length : {{ $center_coords->lat }},
                            lng: locations.length ? locations.reduce((sum, loc) => sum + parseFloat(loc.lng), 0) / locations.length : {{ $center_coords->lang }}
                        };
                        var map = new google.maps.Map(document.getElementById('hospitals-map'), {
                            zoom: locations.length > 1 ? Math.min(15, Math.max(8, 12 - Math.log(locations.length))) : 13,
                            center: center
                        });
                        var infowindow = new google.maps.InfoWindow({});
                        var marker;
                        for (i = 0; i < locations.length; i++) {
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                                map: map,
                                title: locations[i].name
                            });
                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    infowindow.setContent(
                                        '<div style="padding: 10px;">' +
                                        '<h4 style="margin: 0 0 5px 0;">' + locations[i].name + '</h4>' +
                                        '<p style="margin: 0 0 5px 0;"><strong>Address:</strong> ' + locations[i].address + '</p>' +
                                        '<p style="margin: 0 0 5px 0;"><strong>Facilities:</strong> ' + locations[i].facility + '</p>' +
                                        '<p style="margin: 0;"><strong>Phone:</strong> ' + locations[i].phone + '</p>' +
                                        '<a href="https://www.google.com/maps/@' + locations[i].lat + ',' + locations[i].lng + ',10z" target="_blank">View in Google Maps</a>' +
                                        '</div>'
                                    );
                                    infowindow.open(map, marker);
                                }
                            })(marker, i));
                        }
                    }
                </script>
            </div>
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('hospital_add')
                    <a href="{{ url('hospital/create') }}">{{ __('Add New') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display text-center table datatable">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th> # </th>
                                <th>{{__('Name')}}</th>

                                <th>{{__('Status')}}</th>
                                @if (Gate::check('hospital_edit') || Gate::check('hospital_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hospitals as $hospital)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$hospital->id}}" id="{{$hospital->id}}" data-id="{{ $hospital->id }}" class="sub_chk">
                                        <label for="{{$hospital->id}}"></label>
                                    </td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$hospital->name}}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$hospital->id}}" class="custom-switch-input" name="status" onchange="change_status('hospital',{{ $hospital->id }})" {{ $hospital->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('hospital_edit') || Gate::check('hospital_delete'))
                                        <td>
                                            @can('hospital_edit')
                                            <a class="text-success" href="{{url('hospital/'.$hospital->id.'/edit/')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('hospital_delete')
                                            <a class="text-danger"  href="javascript:void(0);" onclick="deleteData('hospital',{{ $hospital->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            @endcan
                                            @can('hospital_gallery_access')
                                                <a href="{{ url('hospitalGallery/'.$hospital->id) }}" class="btn btn-sm bg-primary-light ml-1">
                                                    <i class="fe fe-plus"></i> {{('Hospital gallery')}}
                                                </a>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <input type="button" value="delete selected" onclick="deleteAll('hospital_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>

@endsection

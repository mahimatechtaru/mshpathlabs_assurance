@extends('layout.mainlayout_admin',['activePage' => 'lab'])

@section('title',__('Laboratory'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Laboratory'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-body">
                <div id="labs-map" style="width: 100%; height: 300px;"></div>
                <script defer
                    src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\Setting::select('map_key')->first()->map_key }}&callback=initMap&loading=async">
                </script>
                <script>
                    function initMap() {
                        var locations = @json($labs);
                        var center = {
                            lat: locations.length ? locations.reduce((sum, loc) => sum + parseFloat(loc.lat), 0) / locations.length : {{ $center_coords->lat }},
                            lng: locations.length ? locations.reduce((sum, loc) => sum + parseFloat(loc.lng), 0) / locations.length : {{ $center_coords->lang }}
                        };
                        var map = new google.maps.Map(document.getElementById('labs-map'), {
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
                                        '<p style="margin: 0 0 5px 0;"><strong>Owner:</strong> ' + locations[i].user.name + '</p>' +
                                        '<p style="margin: 0 0 5px 0;"><strong>Address:</strong> ' + locations[i].address + '</p>' +
                                        '<p style="margin: 0;"><strong>Phone:</strong> ' + locations[i].user.phone_code + locations[i].user.phone + '</p>' +
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
                @can('lab_add')
                    <a href="{{  url('laboratory/create') }}">{{ __('Add New') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th>#</th>
                                <th>{{__('Laboratory Image')}}</th>
                                <th>{{__('Laboratory Name')}}</th>
                                <th>{{__('Pathologist Name')}}</th>
                                <th>{{__('Pathologist email')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('lab_edit') || Gate::check('lab_delete'))
                                    <th>{{__('Actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labs as $lab)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$lab->id}}" id="{{$lab->id}}" data-id="{{ $lab->id }}" class="sub_chk">
                                        <label for="{{$lab->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img class="avatar-img rounded-circle" width="50px" height="50px" src="{{ $lab->fullImage }}" alt="doctor Image"></a>
                                    </td>
                                    <td>{{ $lab->name }}</td>
                                    <td>{{ $lab->user['name'] }}</td>
                                    <td>
                                        <a href="mailto:{{$lab->user['email']}}">
                                            <span class="text_transform_none">{{ $lab->user['email'] }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox"id="status_1{{$lab->id}}" class="custom-switch-input" onchange="change_status('lab',{{ $lab->id }})" {{ $lab->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('lab_edit') || Gate::check('lab_delete'))
                                        <td>
                                            @can('lab_edit')
                                            <a class="text-success" href="{{url('laboratory/'.$lab->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('lab_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('laboratory',{{ $lab->id }})">
                                                <i class="far fa-trash-alt"></i>
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
            <div class="card_fotter">
                <input type="button" value="delete selected" onclick="deleteAll('lab_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>

@endsection

@extends('layout.mainlayout_admin',['activePage' => 'setting'])

@section('title',__('Setting'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
    'title' => __('Setting'),
    ])

    @if (session('status'))
    @include('superAdmin.auth.status',[
    'status' => session('status')])
    @endif
    @if (isset($error))
    <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <div class="card">

        <div class="card-header w-100 text-right d-flex justify-content-between">
            @include('superAdmin.auth.exportButtons')
            <a href="{{url('/set_key')}}" >{{__('Set Zoom Key')}}</a>
            {{-- <a href="{{url('/create_zoom_metting')}}" >{{__('Create Zoom Metting')}}</a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="datatable table table-hover table-center mb-0 text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Metting Id')}}</th>
                            <th>{{__('Topic')}}</th>
                            <th>{{__('Start Time')}}</th>
                            <th>{{__('Duration')}}</th>
                            <th>{{__('Agenda')}}</th>
                            <th>{{__('Join Url')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['meetings'] as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value['id'] }}</td>
                            <td>{{ $value['topic'] }}</td>
                            <td>{{ $value['start_time'] }}</td>
                            <td>{{ $value['duration'] }}</td>
                            <td>{{ $value['agenda'] }}</td>
                            <td ><a href="{{url($value['join_url'])}}" class="text_transform_none" target="_blank">{{$value['join_url']}}</a></td>
                            <td>
                                <a href="{{ url('edit_meeting/'.$value['id']) }}"  data-toggle="tooltip" data-placement="top" title="Edit" data-toggle="modal" class="text-success  mr-1">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="{{ url('delete_meeting/'.$value['id']) }}"  data-toggle="tooltip" data-placement="top" title="Delete" data-toggle="modal" class="text-danger ">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

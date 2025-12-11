@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title',__('All Doctor'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Doctor'),
    ])
    @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
    <div class="section_body">
    <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                <div class="d-flex justify-content-end">
                        @role('super admin')
                            <a href="{{ url('logout_all_doctors') }}" class="px-4" onclick="return confirm('{{__('Are you sure you want to logout all doctors?')}}')">{{ __('Logout All') }}</a>
                        @endrole
                        @can('doctor_add')
                            <a href="{{ url('doctor/create') }}">{{ __('Add New') }}</a>
                        @endcan
               </div>
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
                                <th>{{__('Doctor Name')}}</th>
                                <th>{{__('email')}}</th>
                                <th>{{__('Speciality')}}</th>
                                <th>{{__('Based On')}}</th>
                                <th>{{__('Member Since')}}</th>
                                <th>{{__('OTP')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('doctor_edit') || Gate::check('doctor_delete'))
                                    <th>{{__('Actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$doctor->id}}" id="{{$doctor->id}}" data-id="{{ $doctor->id }}" class="sub_chk">
                                        <label for="{{$doctor->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/dashboard') }}" class="avatar avatar-sm mr-2">
                                            <img class="avatar-img rounded-circle" src="{{ $doctor->fullImage }}" alt="doctor Image"></a>
                                        <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/dashboard') }}">{{ $doctor->name }}</a>
                                    </td>
                                    <td>
                                        <a href="mailto:{{$doctor->user['email']}}">
                                            <span class="text_transform_none">{{ $doctor->user['email'] }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($doctor->expertise != null)
                                            {{ $doctor->expertise['name'] }}
                                        @else
                                            {{__('Not define')}}
                                        @endif
                                    </td>
                                    <td>{{ $doctor->based_on }}</td>
                                    @php
                                        $since = explode(" , ",$doctor->since)
                                    @endphp
                                    <td>{{ $since[0] }}<br><small>{{ $since[1] }}</small></td>
                                    <td>{{ $doctor->user->otp ?? '' }}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox"id="status_1{{$doctor->id}}" class="custom-switch-input" onchange="change_status('doctor',{{ $doctor->id }})" {{ $doctor->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('doctor_edit') || Gate::check('doctor_delete'))
                                        <td>
                                            <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/dashboard') }}" class="text-info">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            @can('doctor_edit')
                                            <a class="text-success" href="{{url('doctor/'.$doctor->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('doctor_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('doctor',{{ $doctor->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                                <a href="{{route('loginAsDoctor', $doctor->user->id)}}" data-toggle="tooltip" data-placement="top" title="{{__('Login as')}}">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </a>
                                            <a href="{{route('logoutUser', $doctor->user->id)}}" data-toggle="tooltip" data-placement="top" title="{{__('Logout')}}" onclick="return confirm('{{__('Are you sure you want to logout this user?')}}')">
                                                <i class="fas fa-sign-out-alt text-danger"></i>
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
                <input type="button" value="delete selected" onclick="deleteAll('doctor_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>

@endsection

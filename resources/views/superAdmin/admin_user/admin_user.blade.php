@extends('layout.mainlayout_admin',['activePage' => 'admin_users'])

@section('title',__('Admin User'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Admin Users'),
    ])
    <div class="section-body">
        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('admin_user_add')
                    <a href="{{ url('admin_users/create') }}">{{ __('Add New') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display table datatable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Role')}}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('admin_user_edit') || Gate::check('admin_user_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>
                                        @foreach ($user->roles as $item)
                                            <span class="badge badge-lg badge-primary m-1">{{ $item['name'] }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text_transform_none">{{$user->email}}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$user->id}}" class="custom-switch-input" name="status" onchange="change_status('admin_users',{{ $user->id }})" {{ $user->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    <td>
                                        @if (Gate::check('admin_user_edit') || Gate::check('admin_user_delete'))
                                            @can('admin_user_edit')
                                            <a class="text-success" href="{{url('admin_users/'.$user->id.'/edit/')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('admin_user_delete')
                                            <a class="text-danger" href="javascript:void(0);" href="javascript:void(0)" onclick="deleteData('admin_users',{{ $user->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

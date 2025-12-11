@extends('layout.mainlayout_admin',['activePage' => 'role'])

@section('title',__('All role'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Role'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
        <div class="card">
            {{--! Mixing Roles & Permission is NOT feasible. UNCOMMENT FOLLOWING BUTTON AT YOUR OWN RISK ONLY --}}
            {{-- <div class="card-header">
                @include('superAdmin.auth.exportButtons')
                @can('role_add')
                    <a href="{{ url('role/create') }}" class="w-100 text-right">{{ __('Add New') }}</a>
                @endcan
            </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display table datatable text-center">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{__('role name')}}</th>
                                <th>{{__('permissions')}}</th>
                                @if (Gate::check('role_edit') || Gate::check('role_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        @if($role->name == "super admin")
                                            <span class="badge badge-lg badge-primary m-1">{{ __('All') }}</span>
                                        @else
                                            @forelse ($role->permissions as $permission)
                                                <span class="badge badge-lg badge-primary m-1">{{$permission->name}}</span>
                                            @empty
                                                <span class="badge  badge-lg badge-warning m-1">{{__('No Data')}}</span>
                                            @endforelse
                                        @endif
                                    </td>
                                    <td>
                                        @if (Gate::check('role_edit') || Gate::check('role_delete'))
                                            @can('role_edit')
                                                @if ($role->default == 0)
                                                    <a class="text-success {{ $role->name == 'super admin' ? 'disabled' : ''  }} {{ $role->name == 'pharmacy' ? 'disabled' : ''  }} {{ $role->name == 'doctor' ? 'disabled' : ''  }}" href="{{url('role/'.$role->id.'/edit/')}}">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                            @can('role_delete')
                                                @if ($role->default == 0)
                                                    <a href="javascript:void(0)"  class="text-danger {{ $role->name == 'super admin' ? 'disabled' : ''  }} {{ $role->name == 'pharmacy' ? 'disabled' : ''  }} {{ $role->name == 'doctor' ? 'disabled' : ''  }}" onclick="deleteData('role',{{ $role->id }})">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                @endif
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

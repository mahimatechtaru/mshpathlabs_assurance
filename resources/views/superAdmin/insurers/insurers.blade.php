@extends('layout.mainlayout_admin',['activePage' => 'insurers'])

@section('title',__('All Insurer'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Insurers'),
    ])
    <div class="section-body">
        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('insurer_add')
                    <a href="{{ url('insurers/create') }}">{{ __('Add New') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display table datatable">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th> # </th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('insurer_edit') || Gate::check('insurer_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insurers as $insurer)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$insurer->id}}" id="{{$insurer->id}}" data-id="{{ $insurer->id }}" class="sub_chk">
                                        <label for="{{$insurer->id}}"></label>
                                    </td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$insurer->name}}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$insurer->id}}" class="custom-switch-input" name="status" onchange="change_status('insurers',{{ $insurer->id }})" {{ $insurer->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('insurer_edit') || Gate::check('insurer_delete'))
                                        <td>
                                            @can('insurer_edit')
                                            <a class="text-success" href="{{url('insurers/'.$insurer->id.'/edit/')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('insurer_delete')
                                            <a class="text-danger" href="javascript:void(0);" href="javascript:void(0)" onclick="deleteData('insurers',{{ $insurer->id }})">
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
            <div class="card-footer">
                <input type="button" value="{{__('Delete Selected')}}" onclick="deleteAll('insurer_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>
@endsection

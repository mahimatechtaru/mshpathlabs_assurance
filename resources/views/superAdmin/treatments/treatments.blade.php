@extends('layout.mainlayout_admin',['activePage' => 'treatments'])

@section('title',__('All Treatments'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Treatments'),
    ])
    <div class="section-body">
        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('treatment_add')
                    <a href="{{ url('treatments/create') }}">{{ __('Add New') }}</a>
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
                                <th>{{__('image')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('treatment_edit') || Gate::check('treatment_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($treats as $treat)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$treat->id}}" id="{{$treat->id}}" data-id="{{ $treat->id }}" class="sub_chk">
                                        <label for="{{$treat->id}}"></label>
                                    </td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a href="{{ $treat->fullImage }}" data-fancybox="gallery2">
                                            <img src="{{ $treat->fullImage }}" width="50" height="50" class="rounded" alt="">
                                        </a>
                                    </td>
                                    <td>{{$treat->name}}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$treat->id}}" class="custom-switch-input" name="status" onchange="change_status('treatments',{{ $treat->id }})" {{ $treat->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('treatment_edit') || Gate::check('treatment_delete'))
                                        <td>
                                            @can('treatment_edit')
                                            <a class="text-success" href="{{url('treatments/'.$treat->id.'/edit/')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('treatment_delete')
                                            <a class="text-danger" href="javascript:void(0);" href="javascript:void(0)" onclick="deleteData('treatments',{{ $treat->id }})">
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
                <input type="button" value="{{__('Delete Selected')}}" onclick="deleteAll('treatment_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>
@endsection

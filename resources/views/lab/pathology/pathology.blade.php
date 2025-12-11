@extends('layout.mainlayout_admin',['activePage' => 'pathology'])

@section('title',__('Pathology'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Pathology'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('pathology_add')
                    <a href="{{  url('pathology/create') }}">{{ __('Add New') }}</a>
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
                                <th>{{__('Name')}}</th>
                                @if (!auth()->user()->hasRole('laboratory') && Gate::check('radiology_access'))
                                    <th>{{ __('Laboratory name') }}</th>
                                @endif
                                <th>{{ __('pathology Category name') }}</th>
                                <th>{{ __('Method') }}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('pathology_edit') || Gate::check('pathology_delete'))
                                    <th>{{__('Actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pathologies as $pathology)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$pathology->id}}" id="{{$pathology->id}}" data-id="{{ $pathology->id }}" class="sub_chk">
                                        <label for="{{$pathology->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pathology->test_name }}</td>
                                    @if (!auth()->user()->hasRole('laboratory') && Gate::check('radiology_access'))
                                        <td>{{ $pathology->lab['name'] }}</td>
                                    @endif
                                    <td>{{ $pathology->pathology_category['name'] }}</td>
                                    <td>{{ $pathology->method }}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox"id="status_1{{$pathology->id}}" class="custom-switch-input" onchange="change_status('pathology',{{ $pathology->id }})" {{ $pathology->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('pathology_edit') || Gate::check('pathology_delete'))
                                        <td>
                                            @can('pathology_edit')
                                            <a class="text-success" href="{{url('pathology/'.$pathology->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('pathology_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('pathology',{{ $pathology->id }})">
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
                <input type="button" value="delete selected" onclick="deleteAll('pathology_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>
@endsection

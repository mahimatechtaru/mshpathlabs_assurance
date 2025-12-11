@extends('layout.mainlayout_admin',['activePage' => 'radiology'])

@section('title',__('Radiology'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Radiology'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('radiology_add')
                    <a href="{{  url('radiology/create') }}">{{ __('Add New') }}</a>
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
                                @if (!auth()->user()->hasRole('laboratory') && Gate::check('radiology_access'))
                                    <th>{{ __('laboratory name') }}</th>
                                @endif
                                <th>{{ __('radiology Category name') }}</th>
                                <th>{{ __('Report Days') }}</th>
                                <th>{{ __('Charge') }}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('radiology_edit') || Gate::check('radiology_delete'))
                                    <th>{{__('Actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($radiologies as $radiology)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$radiology->id}}" id="{{$radiology->id}}" data-id="{{ $radiology->id }}" class="sub_chk">
                                        <label for="{{$radiology->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    @if (!auth()->user()->hasRole('laboratory') && Gate::check('radiology_access'))
                                        <td>{{ $radiology->lab['name'] }}</td>
                                    @endif
                                    <td>{{ $radiology->radiology_category['name'] }}</td>
                                    <td>{{ $radiology->report_days }}</td>
                                    <td>{{ $currency }}{{ $radiology->charge }}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox"id="status_1{{$radiology->id}}" class="custom-switch-input" onchange="change_status('radiology',{{ $radiology->id }})" {{ $radiology->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('radiology_edit') || Gate::check('radiology_delete'))
                                        <td>
                                            @can('radiology_edit')
                                            <a class="text-success" href="{{url('radiology/'.$radiology->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('radiology_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('radiology',{{ $radiology->id }})">
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
                <input type="button" value="delete selected" onclick="deleteAll('radiology_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>
@endsection

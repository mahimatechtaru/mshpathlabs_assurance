@extends('layout.mainlayout_admin',['activePage' => 'expertise'])

@section('title',__('All expertise'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Expertise'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('expertise_add')
                    <a href="{{  url('expertise/create') }}">{{ __('Add New') }}</a>                
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display table datatable text-center">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th> # </th>
                                <th>{{__('expertise name')}}</th>
                                <th>{{__('category Name')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('expertise_edit') || Gate::check('expertise_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expertises as $expertis)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$expertis->id}}" id="{{$expertis->id}}" data-id="{{ $expertis->id }}" class="sub_chk">
                                        <label for="{{$expertis->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $expertis->name }}</td>
                                    <td>{{ $expertis->category['name'] }}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$expertis->id}}" class="custom-switch-input" name="status" onchange="change_status('expertise',{{ $expertis->id }})" {{ $expertis->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('expertise_edit') || Gate::check('expertise_delete'))
                                        <td>
                                            @can('expertise_edit')
                                            <a class="text-success" href="{{url('expertise/'.$expertis->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('expertise_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('expertise',{{ $expertis->id }})">
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
                <input type="button" value="delete selected" onclick="deleteAll('expertise_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>
@endsection

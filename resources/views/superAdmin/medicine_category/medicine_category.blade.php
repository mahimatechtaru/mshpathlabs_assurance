@extends('layout.mainlayout_admin',['activePage' => 'medicineCategory'])

@section('title',__('All Medicine Category'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Medicine Category'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('medicine_category_add')
                    <a href="{{ url('medicineCategory/create') }}">{{ __('Add New') }}</a>
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
                                <th>{{__('Category name')}}</th>
                                <th>{{__('status')}}</th>
                                @if (Gate::check('medicine_category_edit') || Gate::check('medicine_category_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicineCategories as $medicineCategory)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$medicineCategory->id}}" id="{{$medicineCategory->id}}" data-id="{{ $medicineCategory->id }}" class="sub_chk">
                                        <label for="{{$medicineCategory->id}}"></label>
                                    </td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$medicineCategory->name}}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$medicineCategory->id}}" class="custom-switch-input" name="status" onchange="change_status('medicineCategory',{{ $medicineCategory->id }})" {{ $medicineCategory->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('medicine_category_edit') || Gate::check('medicine_category_delete'))
                                        <td>
                                            @can('medicine_category_edit')
                                            <a class="text-success" href="{{url('medicineCategory/'.$medicineCategory->id.'/edit/')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('medicine_category_delete')
                                                <a class="text-danger" href="javascript:void(0);" onclick="deleteData('medicineCategory',{{ $medicineCategory->id }})">
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
                <input type="button" value="delete selected" onclick="deleteAll('medicineCategory_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>

@endsection


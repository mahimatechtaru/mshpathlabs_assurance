@extends('layout.mainlayout_admin',['activePage' => 'category'])

@section('title',__('All Category'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Category'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif
    <div class="section_body">
        <div class="card">
            <div class="card-header w-100 d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('category_add')
                    <a href="{{ url('category/create') }}">{{ __('Add New') }}</a>
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
                                <th>{{__('Image')}}</th>
                                <th>{{__('category name')}}</th>
                                <th>{{__('treatment Name')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('category_edit') || Gate::check('category_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <input type="checkbox" name="id[]" value="{{$category->id}}" id="{{$category->id}}" data-id="{{ $category->id }}" class="sub_chk">
                                    <label for="{{$category->id}}"></label>
                                </td>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="{{ $category->fullImage }}" data-fancybox="gallery2">
                                        <img class="avatar-img rounded-circle" src="{{ $category->fullImage }}" height="50" width="50">
                                    </a>
                                </td>
                                <td>
                                    {{$category->name}}
                                    </td>
                                <td>
                                    <a href="{{url('category/'.$category->id.'/edit')}}">
                                    {{$category->treatment['name']}}</a>
                                </td>
                                <td>
                                    <label class="cursor-pointer">
                                        <input type="checkbox" id="status{{$category->id}}" class="custom-switch-input" name="status" onchange="change_status('category',{{ $category->id }})" {{ $category->status == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </td>
                                @if (Gate::check('category_edit') || Gate::check('category_delete'))
                                    <td>
                                        @can('category_edit')
                                        <a class="text-success" href="{{url('category/'.$category->id.'/edit/')}}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('category_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('category',{{ $category->id }})">
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
                <input type="button" value="{{__('delete selected')}}" onclick="deleteAll('category_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>

@endsection

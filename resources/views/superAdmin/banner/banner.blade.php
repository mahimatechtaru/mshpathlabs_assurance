@extends('layout.mainlayout_admin',['activePage' => 'banner'])

@section('title',__('All banner'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Banner'),
    ])
    <div class="section_body">
        @if (session('status'))
            @include('superAdmin.auth.status',[
                'status' => session('status')])
            @endif
        <div class="card">
            <div class="card-header w-100 d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @if (count($banners) < 3)
                    @can('banner_add')
                        <a href="{{ url('banner/create') }}">{{__("Add New") }}</a>
                    @endcan
                @endif
            </div>
            <div class="card-body">
                    <table class="w-100 display table datatable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('banner_edit') || Gate::check('banner_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a href="{{ $banner->fullImage }}" data-fancybox="gallery2">
                                            <img class="avatar-img rounded-circle" alt="User Image" src="{{ $banner->fullImage }}" height="50" width="50">
                                        </a>
                                    </td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$banner->id}}" class="custom-switch-input" name="status" onchange="change_status('banner',{{ $banner->id }})" {{ $banner->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('banner_edit') || Gate::check('banner_delete'))
                                        <td>
                                            @can('banner_edit')
                                            <a class="text-success" href="{{url('banner/'.$banner->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('banner_delete')
                                                <a class="text-danger" href="javascript:void(0);" onclick="deleteData('banner',{{ $banner->id }})">
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
    </div>
</section>

@endsection

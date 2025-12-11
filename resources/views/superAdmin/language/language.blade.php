@extends('layout.mainlayout_admin',['activePage' => 'language'])

@section('title',__('All Language'))

@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Language'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                <div>
                    <a href="{{ url('downloadFile') }}" class="btn btn-primary">{{__('Download Sample File')}}</a>
                    @can('language_add')
                        <a href="{{ url('language/create') }}">{{__('Add New')}}</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable table-center mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Language Image')}}</th>
                                <th>{{__('Language Name')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('language_edit') || Gate::check('language_delete'))
                                    <th>{{__('Actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($languages as $language)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ $language->fullImage }}" data-fancybox="gallery2">
                                            <img src="{{ $language->fullImage }}" width="50" height="50" class="rounded" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        {{ $language->name }}
                                    </td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$language->id}}" class="custom-switch-input" name="status" onchange="change_status('language',{{ $language->id }})" {{ $language->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    @if (Gate::check('language_edit') || Gate::check('language_delete'))
                                        <td>
                                            @can('language_edit')
                                            <a class="text-success" href="{{url('language/'.$language->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('language_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('language',{{ $language->id }})">
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
    </div>
</section>

@endsection

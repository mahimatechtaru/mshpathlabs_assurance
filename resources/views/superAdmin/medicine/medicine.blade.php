@extends('layout.mainlayout_admin',['activePage' => 'pharmacy'])

@section('title',__('All pharmacy Medicine'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Pharmacy Details'),
        'url' => url('pharmacy'),
        'urlTitle' => __('Pharmacy'),
    ])
    <div class="section_body">
        <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
                <a href="{{ $pharmacy->fullImage }}" data-fancybox="gallery2">
                    <img alt="image" src="{{ $pharmacy->fullImage }}" class="rounded-circle profile-widget-picture">
                </a>
                <div class="btn-group mb-2 dropleft float-right p-3">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More Details') }}
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">
                      <a class="dropdown-item" href="{{ url('pharmacy/'.$pharmacy->id) }}">{{__('Dashboard')}}</a>
                      <a class="dropdown-item" href="{{ url('pharmacy_schedule/'.$pharmacy->id) }}">{{__('Schedule Timings')}}</a>
                      <a class="dropdown-item" href="{{ url('pharmacy_commission/'.$pharmacy->id) }}">{{__('commission')}}</a>
                    </div>
                </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $pharmacy->name }}</div>
                {!! clean($pharmacy->description) !!}
            </div>
        </div>

        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between mt-2 p-1">
                @include('superAdmin.auth.exportButtons')
                @can('admin_medicine_add')
                    <a href="{{url('medicine/create/'.$pharmacy->id)}}" class="btn btn-primary float-right">{{__('Add New')}}</a>
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
                                <th>{{__('Name')}}</th>
                                <th>{{__('Incoming stock')}}</th>
                                <th>{{__('Total available Stock')}}</th>
                                <th>{{__('Total Sell')}}</th>
                                <th>{{__('Price')}}({{__('pr Strip')}})</th>
                                <th>{{__('change stock')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('admin_medicine_edit') || Gate::check('admin_medicine_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines as $medicine)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$medicine->id}}" id="{{$medicine->id}}" data-id="{{ $medicine->id }}" class="sub_chk">
                                        <label for="{{$medicine->id}}"></label>
                                    </td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$medicine->name}}</td>
                                    <td>{{$medicine->incoming_stock}}</td>
                                    <td>{{$medicine->total_stock}}</td>
                                    <td>{{$medicine->use_stock}}</td>
                                    <td>{{ $currency }}{{$medicine->price_pr_strip}}</td>
                                    <th>
                                        <a data-toggle="modal" onclick="display_stock({{$medicine->id}})" href="#edit_specialities_details">{{__('change available stock')}}</a>
                                    </th>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox" id="status{{$medicine->id}}" class="custom-switch-input" name="status" onchange="change_status('medicine',{{ $medicine->id }})" {{ $medicine->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    <td>
                                        @if (Gate::check('admin_medicine_edit') || Gate::check('admin_medicine_delete'))
                                            @can('admin_medicine_edit')
                                            <a class="text-success" href="{{url('medicine/'.$medicine->id.'/edit/')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('admin_medicine_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('medicine',{{ $medicine->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" onclick="deleteAll('medicine_all_delete')" class="btn btn-primary">{{__('delete selected')}}</button>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="edit_specialities_details" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ url('medicine/update_stock') }}" method="post" class="myform">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__("change stock")}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="medicine_id">
                    <div class="row form-row">
                        <div class="col-12 col-sm-12">
                            <div class="form-group">
                                <label>{{__('Total income stocks')}}</label>
                                <input type="number" min="1" required name="incoming_stock" class="form-control incoming_stock">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

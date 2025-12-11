@extends('layout.mainlayout_admin',['activePage' => 'medicine'])

@section('title',__('All Pharmacy Medicine'))
@section('content')
<section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Medicine'),
        ])
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('medicine_add')
                    <a href="{{url('medicines/create')}}">{{__('Add New')}}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display table datatable text-center">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Incoming stock')}}</th>
                                <th>{{__('Total available Stock')}}</th>
                                <th>{{__('Total Sell')}}</th>
                                <th>{{__('Price')}}({{__('pr Strip')}})</th>
                                <th>{{__('change stock')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('medicine_edit') || Gate::check('medicine_delete'))
                                    <th> {{__('Action')}} </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines as $medicine)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a href="{{ $medicine->fullImage }}" data-fancybox="gallery2">
                                            <img class="avatar-img rounded-circle" alt="User Image" src="{{ $medicine->fullImage }}" height="50" width="50">
                                        </a>
                                    </td>
                                    <td>
                                        {{$medicine->name}}
                                    </td>
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
                                    @if (Gate::check('medicine_edit') || Gate::check('medicine_delete'))
                                        <td>
                                            @can('medicine_edit')
                                            <a class="text-success" href="{{url('medicines/'.$medicine->id.'/edit/')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('medicine_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('medicines',{{ $medicine->id }})">
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


<div class="modal fade hide" id="edit_specialities_details" role="dialog" aria-hidden="true">
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
                                <input type="number" required name="incoming_stock" class="form-control incoming_stock">
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

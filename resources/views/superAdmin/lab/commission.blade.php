@extends('layout.mainlayout_admin',['activePage' => 'commission'])

@section('title',__('Commission'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Commission'),
    ])

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>{{__('Settlements')}}</h4>
                <span class="badge badge-success">{{__('admin gives to Lab')}}</span>&nbsp;
                <span class="badge badge-danger">{{__('Lab gives to admin')}}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('duration')}}</th>
                                <th>{{__('Report count')}}</th>
                                <th>{{__('Admin Earning')}}</th>
                                <th>{{__('Lab earning')}}</th>
                                <th>{{__('Settles amount')}}</th>
                                <th>{{__('view')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settels as $settel)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td id="duration{{$loop->iteration}}">{{ $settel['duration'] }}</td>
                                    <td>{{ $settel['d_total_task'] }}</td>
                                    <td>{{ $currency }}{{ $settel['admin_earning'] }}</td>
                                    <td>{{ $currency }}{{ $settel['lab_amount'] }}</td>
                                    <td>
                                        @if($settel['d_balance'] > 0)
                                            {{-- admin given --}}
                                            <span class="badge badge-success">{{ $currency }}{{abs($settel['d_balance'])}}</span>
                                        @else
                                            {{-- admin taken --}}
                                            <span class="badge badge-danger">{{ $currency }}{{abs($settel['d_balance'])}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="show_lab_settle_details({{$loop->iteration}})" data-toggle="modal" data-target="#exampleModal">
                                            {{__('Show settlement details')}}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Show settlement details')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body details_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
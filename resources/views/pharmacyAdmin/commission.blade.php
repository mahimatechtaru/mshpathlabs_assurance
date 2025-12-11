@extends('layout.mainlayout_admin',['activePage' => 'commission'])

@section('title',__('commission'))
@section('content')
<section class="section">
        @include('layout.breadcrumb',[
            'title' => __('pharmacy Finance'),
        ])

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <strong>{{__('Last 7 days earning')}}</strong>
                @include('superAdmin.auth.exportButtons')
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="monthFinance" class="table datatable table-striped table-bordered text-center" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Order Amount')}}</th>
                                <th>{{__('Admin Commission')}}</th>
                                <th>{{__('vendor earning')}}</th>
                            </tr>
                        </thead>
                        <tbody class="month_finance">
                            @foreach ($medicines as $order)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $order['date'] }}</td>
                                <td>{{ $currency }}{{ $order['amount'] }}</td>
                                <td>{{ $currency }}{{ $order['admin_commission'] }}</td>
                                <td>{{ $currency }}{{ $order['pharmacy_commission'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>{{__('Settlements')}}</h4>
                <span class="badge badge-success">{{__('admin gives to doctor')}}</span>&nbsp;
                <span class="badge badge-danger">{{__('doctor gives to admin')}}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('duration')}}</th>
                                <th>{{__('Order count')}}</th>
                                <th>{{__('Admin Earning')}}</th>
                                <th>{{__('Pharmacy earning')}}</th>
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
                                    <td>{{ $currency }}{{ $settel['pharmacy_earning'] }}</td>
                                    <td>
                                        @if($settel['d_balance'] > 0)
                                            {{-- admin give --}}
                                            <span class="badge badge-success">{{ $currency }}{{abs($settel['d_balance'])}}</span>
                                        @else
                                            {{-- admin taken --}}
                                            <span class="badge badge-danger">{{ $currency }}{{abs($settel['d_balance'])}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="show_pharmacy_settle_details({{$loop->iteration}})" data-toggle="modal" data-target="#exampleModal">
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
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
@endsection


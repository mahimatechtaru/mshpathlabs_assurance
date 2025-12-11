@extends('layout.mainlayout_admin',['activePage' => 'pharmacy'])

@section('title',__('Show Pharamcy'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Pharmacy Finance Details'),
        'url' => url('pharmacy'),
        'urlTitle' => __('Pharmacy')
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
                      <a class="dropdown-item" href="{{ url('medicine/'.$pharmacy->id) }}">{{__('Medicine')}}</a>
                      <a class="dropdown-item" href="{{ url('pharmacy_schedule/'.$pharmacy->id) }}">{{__('Schedule Timings')}}</a>
                    </div>
                </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $pharmacy->name }}</div>
                {!! clean($pharmacy->description) !!}
            </div>
        </div>

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
                <span class="badge badge-success">{{__('admin gives to pharmacy')}}</span>&nbsp;
                <span class="badge badge-danger">{{__('pharmacy gives to admin')}}</span>
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
                                <th>{{__('pharmacy earning')}}</th>
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
                                            {{-- admin take --}}
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

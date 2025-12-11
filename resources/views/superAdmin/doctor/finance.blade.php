@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title',__('Show Doctor'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Doctor Finance Details'),
        'url' => url('doctor'),
        'urlTitle' =>  __('Doctor'),
    ])
    <div class="section_body">
        <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
                <a href="{{ $doctor->fullImage }}" data-fancybox="gallery2">
                    <img alt="image" src="{{ $doctor->fullImage }}" class="rounded-circle profile-widget-picture">
                </a>
                <div class="btn-group mb-2 dropleft float-right p-3">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('More Details') }}
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">
                      <a class="dropdown-item" href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/dashboard') }}">{{ __('Appointment') }}</a>
                      <a class="dropdown-item" href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/schedule') }}">{{ __('Schedule Timing') }}</a>
                      <a class="dropdown-item" href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/patients') }}">{{ __('Patient') }}</a>
                    </div>
                </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $doctor->name }}
                    <div class="text-muted d-inline font-weight-normal">
                        @if (isset($doctor->expertise))
                        <div class="slash"></div> 
                        {{ $doctor->expertise['name'] }}
                        @endif
                    </div>
                </div>
                {{ $doctor->desc }}
            </div>
        </div>
        
        @if ($doctor->based_on == 'subscription')
            <div class="card">
                <div class="card-header">
                    <h5>{{__('Based On ')}}{{ $doctor->based_on }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('subscription name')}}</th>
                                    <th>{{__('doctor name')}}</th>
                                    <th>{{__('payment')}}</th>
                                    <th>{{__('payment type')}}</th>
                                    <th>{{__('payment status')}}</th>
                                    <th>{{__('subscription date')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $subscription['subscription']->name }}</td>
                                        <td>{{ $subscription['doctor']->name }}</td>
                                        <td>{{ $currency }}{{ $subscription->amount }}</td>
                                        <td>{{ $subscription->payment_type }}</td>
                                        <td>
                                            @if ($subscription->payment_status == 0)
                                                <span class="btn btn-sm bg-danger-light">{{__('unpaid')}}</span>
                                            @else
                                                <span class="btn btn-sm bg-success-light">{{__('paid')}}</span>
                                            @endif
                                        </td>
                                        <td>{{ $subscription->start_date . ' to ' . $subscription->end_date }}</td>
                                        <td>
                                            @if ($subscription->status == 0)
                                                <span class="badge badge-pill bg-danger inv-badge">{{__('expired')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-success inv-badge">{{__('currently available')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if ($doctor->based_on == 'commission')
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <strong>{{__('Last 7 days earning')}}</strong>
                    @include('superAdmin.auth.exportButtons')
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="monthFinance" class="table datatable table-striped table-bordered" cellspacing="0" width="100%">
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
                                @foreach ($appointments as $order)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $order['date'] }}</td>
                                    <td>{{ $currency }}{{ $order['amount'] }}</td>
                                    <td>{{ $currency }}{{ $order['admin_commission'] }}</td>
                                    <td>{{ $currency }}{{ $order['doctor_commission'] }}</td>
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
                                    <th>{{__('Doctor earning')}}</th>
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
                                        <td>{{ $currency }}{{ $settel['doctor_earning'] }}</td>
                                        <td>
                                            @if($settel['d_balance'] > 0)
                                                {{-- admin dese --}}
                                                <span class="badge badge-success">{{ $currency }}{{abs($settel['d_balance'])}}</span>
                                            @else
                                                {{-- admin lese --}}
                                                <span class="badge badge-danger">{{ $currency }}{{abs($settel['d_balance'])}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="show_settle_details({{$loop->iteration}})" data-toggle="modal" data-target="#exampleModal">
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
        @endif
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


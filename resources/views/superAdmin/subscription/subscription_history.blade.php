@extends('layout.mainlayout_admin',['activePage' => 'subscription_history'])

@section('title',__('Subscription History'))

@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Subscription History'),
    ])
    <div class="card">
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
                                <td>{{ auth()->user()->name }}</td>
                                @if ($subscription['subscription']->name != 'free')
                                    <td>{{ $currency }}{{ $subscription->amount }}</td>
                                    <td>{{ $subscription->payment_type }}</td>
                                @else
                                    <td>{{__('Free subscription')}}</td>
                                    <td>{{__('Free subscription')}}</td>
                                @endif
                                <td>
                                    @if(auth()->user()->hasRole('doctor'))
                                        @if ($subscription->payment_status == 0)
                                            <span class="btn btn-sm bg-danger-light">{{__('unpaid')}}</span>
                                        @else
                                            <span class="btn btn-sm bg-success-light">{{__('paid')}}</span>
                                        @endif
                                    @endif
                                    @if(Gate::check('subscription_edit'))
                                        <select {{ $subscription->payment_status == 1 ? 'disabled' : '' }} id="paymentStatus{{$subscription->id}}" onchange="change_paymentStatus({{ $subscription->id }})" name="payment_status" class="form-control">
                                            <option value="1" {{ $subscription->payment_status == 1 ? 'selected' : '' }}>{{__('paid')}}</option>
                                            <option value="0" {{ $subscription->payment_status == 0 ? 'selected' : '' }}>{{__('unpaid')}}</option>
                                        </select>
                                    @endif
                                </td>
                                <td>{{ $subscription->start_date . ' to ' . $subscription->end_date }}</td>
                                <td>
                                    @if ($subscription->status == 0)
                                        <span class="badge badge-pill bg-danger-light">{{__('expired')}}</span>
                                    @else
                                        <span class="badge badge-pill bg-success-light">{{__('currently available')}}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layout.mainlayout_admin',['activePage' => 'subscription'])

@section('title',__('Subscription'))
<style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      text-decoration: none;
      list-style: none;
    }

    body{
      background-color: #30336b;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    </style>

@section('subscription')
<div class="page-wrapper">
    <div class="content container-fluid">
        @include('superAdmin.auth.breadcumb',[
            'mainTitle' => __('subscription'),
            'addUrl' => url('subscription/create'),
            'permission' => 'subscription_add'
        ])

        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="pricing-table">
                        @foreach($subscriptions as $subscription)
                            <div class="col-md-3 mt-5">
                                <div class="pricing-card">
                                    <h3 class="pricing-card-header">{{ $subscription->name }}</h3>
                                    <div class="price">{{ $subscription->total_appointment }}<span> {{__('Booking')}}</span></div>
                                    <ul>
                                        @if ($subscription->name != 'free')
                                            @foreach (json_decode($subscription->plan) as $plan)
                                                <li>
                                                    <strong>{{ $currency }}{{ $plan->price }}/</strong>
                                                    {{ $plan->month }}{{__('month')}}
                                                </li>
                                            @endforeach
                                        @else
                                                <li>
                                                    <strong>{{__('free 1 month validity')}}</strong><br>
                                                    {{__("this can't be edit or delete")}}
                                                </li>
                                        @endif
                                    </ul>
                                    @can('subscription_edit')
                                    <a href="{{ url('subscription/'.$subscription->id.'/edit') }}" class="btn btn-outline-primary m-3  {{ $subscription->name == 'free' ? 'disabled' : '' }}">{{__('Edit')}}</a>
                                    @endcan
                                    @can('subscription_delete')
                                        <a href="javascript:void(0);" onclick="deleteData('subscription',{{ $subscription->id }})" class="btn btn-outline-danger m-3 {{ $subscription->name == 'free' ? 'disabled' : '' }}">{{__('Delete')}}</a>
                                    @endcan
                                    @can('doctor_subscription_purchase')
                                        @if ($subscription->id == $purchase->subscription_id)
                                            <button class="btn btn-primary m-3">{{__('Activate')}}</button>
                                        @else
                                            <a href="{{ url('subscription_purchase/'.$subscription->id) }}" class="btn btn-outline-primary m-3">{{__('Buy')}}</a>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layout.mainlayout_admin',['activePage' => 'subscription'])

@section('title',__('All subscription'))
<style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      text-decoration: none;
      list-style: none;
    }
</style>

@if (auth()->user()->hasRole('doctor'))
    @section('subscription')
@else
    @section('content')
@endif
    <section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Subscription'),
        ])
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100">
                @can('subscription_add')
                    <a href="{{ url('subscription/create') }}" class="w-100 text-right">{{ __('Add New') }}</a>
                @endcan
            </div>
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
                                                    {{ $plan->month }} {{__('month')}}
                                                </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <strong>{{__('free 1 month validity')}}</strong><br>
                                                {{__("this can't be delete")}}
                                            </li>
                                        @endif
                                    </ul>
                                    @can('subscription_edit')
                                    <a href="{{ url('subscription/'.$subscription->id.'/edit') }}" class="btn btn-outline-primary m-3">{{__('Edit')}}</a>
                                    @endcan
                                    @can('subscription_delete')
                                        <a href="javascript:void(0);" onclick="deleteData('subscription',{{ $subscription->id }})" class="btn btn-outline-danger m-3 {{ $subscription->name == 'free' ? 'disabled' : '' }}">{{__('Delete')}}</a>
                                    @endcan
                                    @if (auth()->user()->hasRole('doctor'))
                                        @can('doctor_subscription_purchase')
                                        @if (isset($purchase))
                                            @if ($subscription->id == $purchase->subscription_id)
                                                <button class="btn btn-primary m-3">{{__('Activated')}}</button>
                                            @else
                                                <a href="{{ url('subscription_purchase/'.$subscription->id) }}" class="btn btn-outline-primary m-3 {{ $subscription->name == 'free' ? 'disabled' : '' }}">{{__('Buy')}}</a>
                                            @endif
                                        @else
                                            <a href="{{ url('subscription_purchase/'.$subscription->id) }}" class="btn btn-outline-primary m-3 {{ $subscription->name == 'free' ? 'disabled' : '' }}">{{__('Buy')}}</a>
                                        @endif
                                        @endcan
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

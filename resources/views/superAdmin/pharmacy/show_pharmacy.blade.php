@extends('layout.mainlayout_admin',['activePage' => 'pharmacy'])

@section('title',__('Show Pharamcy'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Pharmacy Details'),
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
                      <a class="dropdown-item" href="{{ url('medicine/'.$pharmacy->id) }}">{{__('Medicine')}}</a>
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

        <div class="card">
            <div class="card-header justify-content-between">
                <h6>{{ __('Purchased Medicine') }}</h6>
                @include('superAdmin.auth.exportButtons')
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display table datatable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{__('Prescription Image')}}</th>
                                <th>{{__('User')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('payment type')}}</th>
                                <th>{{__('payment status')}}</th>
                                <th>{{__('View Medicines')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines as $medicine)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        @if (isset($medicine['pdf']))
                                            <a href="{{ url('prescription/upload/'.$medicine['pdf']) }}"  data-fancybox="gallery2">
                                                {{ $medicine['pdf'] }}
                                            </a>
                                        @else
                                            {{__('No prescription available')}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$medicine->user['name']}}
                                    </td>
                                    <td>{{ $currency }}{{$medicine->amount}}</td>
                                    <td>{{$medicine->payment_type}}</td>
                                    <td>
                                        @if ($medicine->payment_status == 1)
                                            <span class="btn btn-sm bg-success-light">{{__('Paid')}}</span>
                                        @else
                                            <span class="btn btn-sm bg-danger-light">{{__('Unpaid')}}</span>
                                        @endif
                                    </td>
                                    <td> 
                                    <a href="#edit_specialities_details" onclick="show_medicines({{$medicine->id}})" data-toggle="modal" class="text-info">
                                        <i class="far fa-eye"></i>
                                    </a>
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

<div class="modal fade hide" id="edit_specialities_details" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Medicines Details")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{__('shipping At')}}</td>
                            <td class="shippingAt"></td>
                        </tr>
                        <tr class="shippingAddressTr">
                            <td>{{__('shipping Adddress')}}</td>
                            <td class="shippingAddress"></td>
                        </tr>
                        <tr class="shippingAddressTr">
                            <td>{{__('Delivery Charge')}}</td>
                            <td class="deliveryCharge"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <thead>
                        <th>{{__('medicine name')}}</th>
                        <th>{{__('medicine qty')}}</th>
                        <th>{{__('medicine price')}}</th>
                    </thead>
                    <tbody  class="tbody">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

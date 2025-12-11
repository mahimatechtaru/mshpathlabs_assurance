@extends('layout.mainlayout_admin',['activePage' => 'appointment'])

@section('title',__('Appointment'))
<style>
#button-16 .knobs:before
{
    content: 'YES';
    position: absolute;
    top: 4px;
    left: 4px;
    width: 20px;
    height: 10px;
    color: #fff;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    line-height: 1;
    padding: 9px 4px;
    background-color: #03A9F4;
    border-radius: 2px;
    transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
}

#button-16 .checkbox:active + .knobs:before
{
    width: 46px;
}

#button-16 .checkbox:checked:active + .knobs:before
{
    margin-left: -26px;
}

#button-16 .checkbox:checked + .knobs:before
{
    content: 'NO';
    left: 42px;
    background-color: #F44336;
}

#button-16 .checkbox:checked ~ .layer
{
    background-color: #fcebeb;
}
</style>
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Appointment'),
    ])
    <div class="section-body">
        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif

        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100 display table datatable">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th> # </th>
                                <th>{{__('appointment id')}}</th>
                                <th>{{__('Report or patient image')}}</th>
                                <th>{{__('amount')}}</th>
                                @if (!auth()->user()->hasRole('doctor'))
                                    <th>{{__('doctor name')}}</th>
                                @endif
                                <th>{{__('date')}}</th>
                                <th>{{__('payment status')}}</th>
                                <th>{{__('status')}}</th>
                                @if (auth()->user()->hasRole('doctor'))
                                    <th>{{__('change status')}}</th>
                                @endif
                                <th>{{__('view appointment')}}</th>
                                @if (auth()->user()->hasRole('doctor'))
                                    <th>{{__('Add prescription')}}</th>
                                @endif
                                @if (auth()->user()->hasRole('doctor'))
                                    <th>{{__('Zoom Meeting')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$appointment->id}}" id="{{$appointment->id}}" data-id="{{ $appointment->id }}" class="sub_chk">
                                        <label for="{{$appointment->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $appointment->appointment_id }}</td>
                                    <td>
                                        @if ($appointment->report_image != null)
                                            @foreach ($appointment->report_image as $item)
                                                <a href="{{ $item }}" data-fancybox="gallery2">
                                                    <img src="{{ $item }}" alt="Feature Image" width="50px" height="50px">
                                                </a>
                                            @endforeach
                                        @else
                                            {{__('Image Not available')}}
                                        @endif
                                    </td>
                                    <td>{{ $currency }}{{ $appointment->amount }}</td>
                                    @if (!auth()->user()->hasRole('doctor'))
                                        <td>{{ $appointment->doctor['name'] }}</td>
                                    @endif
                                    <td>{{ $appointment->date }}<span class="d-block text-info">{{ $appointment->time }}</span></td>
                                    <td>
                                        @if ($appointment->payment_status == 1)
                                            <span class="btn btn-sm btn-sm btn-success">{{__('Paid')}}</span>
                                        @else
                                            <span class="btn btn-sm btn-sm btn-danger">{{__('Remaining')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($appointment->appointment_status == 'pending' || $appointment->appointment_status == 'PENDING')
                                            <span class="badge badge-pill bg-warning-light">{{__('Pending')}}</span>
                                        @endif
                                        @if($appointment->appointment_status == 'approved' || $appointment->appointment_status == 'APPROVED' ||$appointment->appointment_status == 'approve' )
                                            <span class="badge badge-pill bg-success-light">{{__('Approved')}}</span>
                                        @endif
                                        @if($appointment->appointment_status == 'canceled' || $appointment->appointment_status == 'CANCELED' || $appointment->appointment_status == 'cancel')
                                            <span class="badge badge-pill bg-danger-light">{{__('Cancelled')}}</span>
                                        @endif
                                        @if($appointment->appointment_status == 'completed' || $appointment->appointment_status == 'COMPLETED' || $appointment->appointment_status == 'complete')
                                            <span class="badge badge-pill bg-default-light">{{__('Completed')}}</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->hasRole('doctor'))
                                    <td class="d-flex w-100">
                                        @if ($appointment->appointment_status == 'approve' ||  $appointment->appointment_status == 'complete')
                                            <a href="{{ url('completeAppointment/'.$appointment->id) }}" class="btn btn-sm bg-info-light {{ $appointment->appointment_status == 'complete' ? 'disabled' : '' }}">
                                                <i class="fas fa-check"></i> {{__('Complete')}}
                                            </a>
                                        @elseif($appointment->appointment_status == 'pending' || $appointment->appointment_status != 'cancel')
                                            <a href="{{ url('acceptAppointment/'.$appointment->id) }}" class="btn btn-sm bg-success-light {{ $appointment->appointment_status != 'pending' ? 'disabled' : '' }}">
                                                <i class="fas fa-check"></i> {{__('Accept')}}
                                            </a>
                                            <a href="{{ url('cancelAppointment/'.$appointment->id) }}" class="btn btn-sm bg-danger-light ml-2 {{ $appointment->appointment_status != 'pending' ? 'disabled' : '' }}">
                                                <i class="fas fa-times"></i>{{__('Cancel')}}
                                            </a>
                                        @endif
                                    </td>
                                    @endif
                                    @if(auth()->user()->hasRole('doctor') && $appointment->is_from == 1)
                                        <td>
                                            <a href="#edit_specialities_details" onclick="show_appointment({{$appointment->id}})" data-toggle="modal" class="text-info">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('edit_appointment/'.$appointment->id) }}"  data-toggle="tooltip" data-placement="top" title="Edit" data-toggle="modal" class="text-success">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="{{ url('delete_appointment/'.$appointment->id) }}"  data-toggle="tooltip" data-placement="top" title="Delete" data-toggle="modal" class="text-danger">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="#edit_specialities_details" onclick="show_appointment({{$appointment->id}})" data-toggle="modal" class="text-info">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </td>
                                    @endif
                                    @if (auth()->user()->hasRole('doctor'))
                                    @if ($appointment->prescription == 0)
                                        <td>
                                            <a href="{{ url('prescription/'.$appointment->id) }}"  class="btn btn-sm bg-success-light">
                                                <i class="fas fa-plus"></i>{{__('Add prescription')}}
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{ url('prescription/upload/'.$appointment->preData['pdf']) }}" data-fancybox="gallery2">
                                                {{__('show prescription')}}
                                            </a>
                                        </td>
                                    @endif
                                    @endif
                                    @if (auth()->user()->hasRole('doctor'))
                                    <td>
                                        @if ($is_zoom_enabled)
                                            @if ($appointment->zoom_url)
                                                <a href="{{$appointment->zoom_url}}" target="_blank" >{{__('Go to Meeting')}}</a>
                                            @elseif ($is_zoom_logged_in)
                                                <a href="{{url('create_zoom_meeting/'.$appointment->id)}}" target="_self" >{{__('Create Meeting')}}</a>
                                            @else
                                                <a href="{{$url}}" target="_self" >{{__('Zoom Login')}}</a>
                                            @endif
                                        @else
                                                {{__('Unavailable')}}
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="edit_specialities_details" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Appointment")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>{{__('appointment Id')}}</td>
                        <td class="appointment_id"></td>
                    </tr>
                    <tr>
                        <td>{{__('Doctor name')}}</td>
                        <td class="doctor_name"></td>
                    </tr>
                    <tr>
                        <td>{{__('Hospital')}}</td>
                        <td class="hospital"></td>
                    </tr>
                    <tr>
                        <td>{{__('patient name')}}</td>
                        <td class="patient_name"></td>
                    </tr>
                    <tr>
                        <td>{{__('patient phone')}}</td>
                        <td class="patient_phone"></td>
                    </tr>
                    <tr>
                        <td>{{__('patient address')}}</td>
                        <td class="patient_address"></td>
                    </tr>
                    <tr>
                        <td>{{__('patient age')}}</td>
                        <td class="patient_age"></td>
                    </tr>
                    <tr>
                        <td>{{__('amount')}}</td>
                        <td class="amount"></td>
                    </tr>
                    <tr>
                        <td>{{__('date')}}</td>
                        <td class="date"></td>
                    </tr>
                    <tr>
                        <td>{{__('time')}}</td>
                        <td class="time"></td>
                    </tr>
                    <tr>
                        <td>{{__('Drug Effects')}}</td>
                        <td class="drug_effect"></td>
                    </tr>
                    <tr>
                        <td>{{__('Doctor Note')}}</td>
                        <td class="doctor_note"></td>
                    </tr>
                    <tr>
                        <td>{{__('payment status')}}</td>
                        <td class="payment_status"></td>
                    </tr>
                    <tr>
                        <td>{{__('payment type')}}</td>
                        <td class="payment_type"></td>
                    </tr>
                    <tr>
                        <td>{{__('illness information')}}</td>
                        <td class="illness_info"></td>
                    </tr>
                    <tr>
                        <td>{{__('Patient insured')}}</td>
                        <td class="is_insured"></td>
                    </tr>
                    <tr class="policy_insurer_row">
                        <td>{{__('Policy Provider')}}</td>
                        <td class="policy_insurer_name"></td>
                    </tr>
                    <tr class="policy_number_row">
                        <td>{{__('Policy Number')}}</td>
                        <td class="policy_number"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>

@endsection

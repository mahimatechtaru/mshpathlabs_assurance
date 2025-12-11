@extends('layout.mainlayout_admin',['activePage' => 'setting'])

@section('title',__('Create Meeting'))
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endsection
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
    'title' => __('Create Meeting'),
    ])

    @if (session('status'))
    @include('superAdmin.auth.status',[
    'status' => session('status')])
    @endif
    <div class="card">
        <form action="{{ url('store',$appointment->id) }}" method="post" enctype="multipart/form-data" class="myform">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="col-form-label">{{__('Topic')}}</label>
                            <input type="text" name="topic" class="form-control @error('topic') is-invalid @enderror"
                                value="{{ __('Appointment with').' '.$appointment->patient_name }}">
                            @error('topic')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Date')}}</label>
                                    <input type="text" class="datepicker form-control @error('date') is-invalid @enderror" id="date"
                                        min="{{ Carbon\Carbon::now(env('timezone'))->format('Y-m-d') }}" name="date" value="{{$appointment->date}}" required>
                                    <span class="invalid-div text-danger"><span class="date"></span>
                                    @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Time').' ('.env('timezone').')'}}</label>
                                    <input type="time" name="time"
                                        class="form-control @error('time') is-invalid @enderror"
                                        value="{{Carbon\Carbon::parse($appointment->time)->format('H:i')}}" required>
                                    @error('time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="col-form-label">{{__('Agenda')}}</label>
                            <input type="text" name="agenda" class="form-control @error('agenda') is-invalid @enderror"
                                value="{{ __('Problem').' '.$appointment->illness_information. '. Note: '.$appointment->note }}" required>
                            @error('agenda')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label class="col-form-label">{{__('Send Email to Patient')}}</label>
                            <input type="checkbox" name="send_email" class="form-control @error('send_email') is-invalid @enderror" value="1" checked>
                            @error('send_email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<script>
    var dateToday = new Date();
    $( function() {
        $( ".datepicker" ).datepicker({
            minDate: dateToday,
            numberOfMonths: 1,
            dateFormat: 'yy-mm-dd',
        });
    });
</script>
@endsection

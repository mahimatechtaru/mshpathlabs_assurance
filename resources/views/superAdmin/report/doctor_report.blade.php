@extends('layout.mainlayout_admin',['activePage' => 'doctor_report'])

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
@endsection

@section('title',__('Doctor Report'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Doctor Report'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('doctor_report') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-6">
                            <input type="text" class="form-control" name="update_start_end_date">
                        </div>
                        <div class="col-md-6 col-lg-6 col-6">
                            <input type="submit" value="{{__('Apply')}}" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('Total Doctor')}}</h4>
                      </div>
                      <div class="card-body">
                        <h3>{{ count($doctors) }}</h3>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('Subscription Based Doctor')}}</h4>
                      </div>
                      <div class="card-body">
                        <h3>{{ $subscriptionDoctor }}</h3>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-columns"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('Commission Based Doctor')}}</h4>
                      </div>
                      <div class="card-body">
                        <h3>{{ $commissionDoctor }}</h3>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                @include('superAdmin.auth.exportButtons')

                <div class="table-responsive text-center">
                    <table class="w-100 display table datatable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{__('Doctor Image')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Phone')}}</th>
                                <th>{{__('Based On')}}</th>
                                <th>{{__('Total Appointment')}}</th>
                                <th>{{__('Doctor Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a href="{{ $doctor->fullImage }}" data-fancybox="gallery2">
                                            <img class="avatar-img rounded-circle" alt="User Image" src="{{ $doctor->fullImage }}" height="50" width="50">
                                        </a>
                                    </td>
                                    <td>
                                        {{$doctor->name}}
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $doctor->user['email'] }}">
                                            <span class="text_transform_none">{{$doctor->user['email']}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $doctor->user['phone'] }}">{{$doctor->user['phone']}}</a>
                                    </td>
                                    <td>{{ $doctor->based_on }}</td>
                                    <td>
                                        {{ $doctor->totalOrder }}
                                    </td>
                                    <td>
                                        @if ($doctor->status == 1)
                                            <div class="badge badge-success">{{__('Active')}}</div>
                                        @else
                                            <div class="badge badge-danger">{{__('Dective')}}</div>
                                        @endif
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

@endsection

@section('js')
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
@endsection

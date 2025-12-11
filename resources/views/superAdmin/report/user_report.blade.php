@extends('layout.mainlayout_admin',['activePage' => 'user_report'])

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
@endsection

@section('title',__('User Report'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('User Report'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('user_report') }}" method="post">
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
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('Total Users')}}</h4>
                      </div>
                      <div class="card-body">
                        <h3>{{ count($users) }}</h3>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('Active User')}}</h4>
                      </div>
                      <div class="card-body">
                        <h3>{{ $activeUser }}</h3>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('Block User')}}</h4>
                      </div>
                      <div class="card-body">
                        <h3>{{ $blockUser }}</h3>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                @include('superAdmin.auth.exportButtons')
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="w-100 display table datatable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{__('User Image')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Phone')}}</th>
                                <th>{{__('Total Booking')}}</th>
                                <th>{{__('Remaining Payment')}}</th>
                                <th>{{__('User Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="{{ $user->fullImage }}" data-fancybox="gallery2">
                                        <img class="avatar-img rounded-circle" alt="User Image" src="{{ $user->fullImage }}" height="50" width="50">
                                    </a>
                                </td>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}">
                                        <span class="text_transform_none">{{$user->email}}</span>
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:{{ $user->phone }}">{{$user->phone}}</a>
                                </td>
                                <td>
                                    {{ $user->totalBooking }}
                                </td>
                                <td>
                                    {{ $currency }}{{ $user->RemaingAmount }}
                                </td>
                                <td>
                                    @if ($user->status == 1)
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

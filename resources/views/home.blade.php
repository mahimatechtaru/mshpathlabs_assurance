@extends('layout.mainlayout_admin',['activePage' => 'home'])

@section('title', __('Admin dashboard'))

@section('content')
    <section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Dashboard'),
        ])
        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('Total Patients') }}</h4>
                      </div>
                      <div class="card-body">
                        <h3>{{$totalUsers}}</h3>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                      <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h6 class="text-muted">{{__('Appointment')}}</h6>
                      </div>
                      <div class="card-body">
                        <h3>{{ $totalAppointments }}</h3>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                      <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h6 class="text-muted">{{__('Doctors')}}</h6>
                      </div>
                      <div class="card-body">
                        <h3>{{ $totalDoctors }}</h3>
                      </div>
                    </div>
                  </div>
                </div>               
              </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-lg-6">
              <div class="card card-chart">
                  <div class="card-header">
                      <h4 class="card-title">{{__('Appointments')}}</h4>
                  </div>
                  <div class="card-body">
                      <canvas id="orderChart"></canvas>
                      <input type="hidden" name="years" value="{{ $orderCharts['label'] }}">
                      <input type="hidden" name="data" value="{{ $orderCharts['data'] }}">
                  </div>
              </div>

          </div>
          <div class="col-md-12 col-lg-6">
              <div class="card card-chart">
                  <div class="card-header">
                      <h4 class="card-title">{{__('Doctor - patients')}}</h4>
                  </div>
                  <div class="card-body">
                      <canvas id="usersChart"></canvas>
                      <input type="hidden" name="users" value="{{ $users['user'] }}">
                      <input type="hidden" name="doctors" value="{{ $users['doctor'] }}">
                      <input type="hidden" name="month" value="{{ $users['month'] }}">
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6 d-flex">
              <div class="card card-table flex-fill">
                  <div class="card-header">
                      <h4 class="card-title">{{__('Doctors List')}}</h4>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table datatable table-hover table-center mb-0">
                              <thead>
                                  <tr>
                                      <th>{{__('Doctor Name')}}</th>
                                      <th>{{__('Doctor Base on')}}</th>
                                      <th>{{__('Treatments')}}</th>
                                      <th>{{__('Reviews')}}</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($allDoctors as $doctor)
                                      <tr>
                                          <td>
                                            <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/dashboard') }}" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="{{ $doctor->full_image }}" alt="User Image"></a>
                                            <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/dashboard') }}">{{ $doctor->name }}</a>
                                          </td>
                                          <td>{{ $doctor->based_on }}</td>
                                          <td>
                                              @if(isset($doctor->treatment['name']))
                                                  {{ $doctor->treatment['name'] }}
                                              @endif
                                          </td>
                                          <td>
                                              @for ($i = 1; $i < 6; $i++)
                                              @if ($i <= $doctor->rate)
                                                  <i class="fe fe-star text-warning">
                                              @else
                                                  <i class="fe fe-star-o text-secondary">
                                              @endif
                                          @endfor
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-md-6 d-flex">
              <div class="card  card-table flex-fill">
                  <div class="card-header">
                      <h4 class="card-title">{{__('Latest Patients List')}}</h4>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="dataTable" class="datatable table table-hover table-center mb-0">
                              <thead>
                                  <tr>
                                      <th>{{__('Patient Name')}}</th>
                                      <th>{{__('Phone')}}</th>
                                      <th>{{__('Email')}}</th>
                                      <th>{{__('Gender')}}</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($allUsers as $allUser)
                                      <tr>
                                          <td>
                                              <a href="{{ url('patient/'.$allUser->id) }}" class="avatar avatar-sm mr-2">
                                                  <img class="avatar-img rounded-circle" src="{{ $allUser->fullImage }}" alt="User Image"></a>
                                              <a href="{{ url('patient/'.$allUser->id) }}">{{ $allUser->name }} </a>
                                          </td>
                                          <td>
                                              <a href="tel:{{$allUser->phone}}">{{$allUser->phone}}</a>
                                          </td>
                                          <td>
                                                <a href="mailto:{{ $allUser->email }}">
                                                    <span class="text_transform_none">{{ $allUser->email }}</span>
                                                </a>
                                          </td>
                                          <td>{{ $allUser->gender }}</td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <!-- /Patient Activity -->
          </div>
      </div>
    </section>
@endsection

@section('js')
    <script src="{{url('assets_admin/js/chart.min.js')}}"></script>
    <script src="{{url('assets_admin/js/chart.js')}}"></script>
@endsection
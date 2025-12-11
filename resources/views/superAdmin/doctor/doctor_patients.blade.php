@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title',__('Show Doctor'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Patients'),
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
                      <a class="dropdown-item" href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/finance') }}">{{ __('Finance Details') }}</a>
                    </div>
                </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $doctor->name }}
                    @if (isset($doctor->expertise['name']))
                        <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> 
                            {{ $doctor->expertise['name'] }}
                        </div>
                    @endif
                </div>
                {{ $doctor->desc }}
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                @include('superAdmin.auth.exportButtons')
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('User Name')}}</th>
                                <th>{{__('email')}}</th>
                                <th>{{__('Gender')}}</th>
                                <th>{{__('Date of birth')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ url('patient/'.$user->id) }}" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="{{ $user->fullImage }}" alt="patient Image"></a>
                                            <a href="{{ url('patient/'.$user->id) }}">{{ $user->name }}</a>
                                        </h2>
                                    </td>
                                    <td>
                                        <span class="text_transform_none">{{ $user->email }}</span>
                                    </td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->dob }}</td>
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

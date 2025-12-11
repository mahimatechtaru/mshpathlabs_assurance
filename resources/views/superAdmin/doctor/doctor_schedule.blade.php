@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title',__('Show Doctor'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Doctor Schedule Timing'),
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
                      <a class="dropdown-item" href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/patients') }}">{{ __('Patient') }}</a>
                      <a class="dropdown-item" href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/finance') }}">{{ __('Finance Details') }}</a>
                    </div>
                </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">{{ $doctor->name }}
                    <div class="text-muted d-inline font-weight-normal">
                        @if (isset($doctor->expertise))
                        <div class="slash"></div>
                        {{ $doctor->expertise['name'] }}
                        @endif
                    </div>
                </div>
                {{ $doctor->desc }}
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                {{ __('Schedule Timing') }}
            </div>
            <div class="card-body">
                <input type="hidden" name="start_time" value="{{ $doctor->start_time }}">
                <input type="hidden" name="end_time" value="{{ $doctor->end_time }}">
                <input type="hidden" name="timeslot" value="{{ $doctor->timeslot == 'other' ? $doctor->custom_timeslot : $doctor->timeslot }}">
                <div class="profile-box">
                    <div class="card schedule-widget mb-0">
                        <div class="schedule-header">
                            <div class="schedule-nav">
                                <ul class="nav nav-tabs nav-justified">
                                    @foreach ($doctor->workingHours as $working)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" onclick="display_timeslot({{ $working->id }})" data-toggle="tab" href="#slot_sunday">{{ $working->day_index }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div id="slot_sunday" class="doc-times tab-pane fade show active">
                                <input type="hidden" name="working_id" value="{{$doctor->firstHours->id}}">
                                <h6 class="card-title d-flex float-right justify-content-between">
                                    <a class="btn btn-danger float-right mt-5" data-toggle="modal" onclick="edit_timeslot()" href="#edit_time_slot">
                                        <i class="fa fa-edit mr-1"></i> {{__('Edit Slot')}}
                                    </a>
                                </h6>


                                @foreach (json_decode($doctor->firstHours->period_list) as $list)
                                    <div class="badge badge-primary ml-2 mt-5">
                                        {{$list->start_time}} - {{$list->end_time}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="edit_time_slot" tabindex="-1" role="dialog" aria-labelledby="edit_time_slot" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" method="post" class="working_form" class="myform">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__('Edit Timeslot')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="working_id" value="">
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{__('Day Status')}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="cursor-pointer">
                                    <input type="checkbox" id="status_1" class="custom-switch-input" name="status" checked>
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="hours-info mt-3">
                        <div class="row form-row hours-cont display_timing">
                            <div class="col-12 col-md-10">
                            </div>
                        </div>
                    </div>
                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


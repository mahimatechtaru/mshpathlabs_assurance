@extends('layout.mainlayout_admin',['activePage' => 'schedule'])

@section('title',__('Schedule'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('doctor schedule'),
    ])

        <input type="hidden" name="start_time" value="{{ $doctor->start_time }}">
        <input type="hidden" name="end_time" value="{{ $doctor->end_time }}">
        <input type="hidden" name="timeslot" value="{{ $doctor->timeslot == 'other' ? $doctor->custom_timeslot : $doctor->timeslot }}">
        <div class="card">
            <div class="card-header">
                {{__('Schedule Timings')}}
            </div>
            <div class="card-body">
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
                                    <a class="edit-link btn btn-danger float-right mt-5" data-toggle="modal" onclick="edit_timeslot()" href="#edit_time_slot">
                                        <i class="fa fa-edit mr-1"></i> {{__('Edit Slot')}}
                                    </a>
                                </h4>
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

<div class="modal fade" id="edit_time_slot" tabindex="-1" role="dialog" aria-labelledby="edit_time_slot" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" method="post" class="working_form myform">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__('Edit Time Slot')}}</h5>
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
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> {{__('Add More')}}</a>
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


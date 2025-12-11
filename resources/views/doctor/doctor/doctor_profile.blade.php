@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title','Doctor profile')

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
    'title' => __('Doctor profile'),
    ])

    <form action="{{ url('update_doctor_profile') }}" method="post" enctype="multipart/form-data" class="myform">
        @csrf
        <div class="card">
            <div class="card-header text-primary">
                {{__('personal information')}}
            </div>
            <div class="text-center alert-success mx-4 py-1" style="font-weight:bold;color:#0abf3a;">{{__("Please fill up the following details to enhance the patient's experience.")}}</div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-lg-2 col-md-4">
                        <label for="Doctor_image" class="ul-form__label"> {{__('Doctor image')}}</label>
                        <div class="avatar-upload avatar-box avatar-box-left">
                            <div class="avatar-edit">
                                <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                <label for="image"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{ $doctor->fullImage }});">
                                </div>
                            </div>
                        </div>
                        @error('image')
                        <div class="custom_error">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-10 col-md-8">
                        <div class="form-group">
                            <label class="col-form-label">{{__('Name')}}</label>
                            <input type="text" value="{{ $doctor->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">{{__('email')}}</label>
                            <input type="email" readonly value="{{ $doctor->user['email'] }}" name="email" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6 form-group">
                        <label for="phone_number" class="col-form-label"> {{__('Phone number')}}</label>
                        <div class="d-flex">
                            <select name="phone_code" class="phone_code_select2" disabled>
                                @foreach ($countries as $country)
                                <option value="+{{$country->phonecode}}" {{ $doctor->user['phone_code'] ==
                                    +$country->phonecode ? 'selected' : '' }}>+{{ $country->phonecode }}</option>
                                @endforeach
                            </select>
                            <input type="number" readonly value="{{$doctor->user['phone']}}" name="phone" class="form-control @error('phone') is-invalid @enderror">
                        </div>
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Hospital')}}</label>
                        <select name="hospital_id[]" class="select2 @error('hospital_id') is-invalid @enderror" multiple>
                            @foreach ($hospitals as $hospital)
                            <option value="{{ $hospital->id }}" {{ in_array($hospital->id,$doctor->hospital_id) ?
                                'selected' : '' }}>{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                        @error('hospital_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Date of birth')}}</label>
                        <input type="text" value="{{ $doctor->dob }}" class="form-control datePicker @error('dob') is-invalid @enderror" name="dob">
                        @error('dob')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Gender')}}</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="male" {{ $doctor->gender == 'male' ? 'selected' : '' }}>{{__('male')}}
                            </option>
                            <option value="female" {{ $doctor->gender == 'female' ? 'selected' : '' }}>{{__('female')}}
                            </option>
                            <option value="other" {{ $doctor->gender == 'other' ? 'selected' : '' }}>{{__('other')}}
                            </option>
                        </select>
                        @error('gender')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="language" class="ul-form__label"> {{__('Language')}}</label>
                    <select name="language" class="form-control">
                        @foreach ($languages as $language)
                        <option value="{{ $language->name }}" {{ $doctor->language == $language->name ? 'selected' : ''
                            }}>{{ $language->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label">{{__('Professional Bio')}}</label>
                    <textarea name="desc" rows="10" cols="10" class="form-control @error('desc') is-invalid @enderror">{{ $doctor->desc }}</textarea>
                    @error('desc')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-primary">
                {{__('Education and certificate(award details)')}}
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label">{{__('Add Education')}}</label>
                    <div class="education-info">
                        @if (json_decode($doctor->education))
                        @foreach (json_decode($doctor->education) as $education)
                        <div class="row form-row education-cont">
                            <div class="col-12 col-md-10 col-lg-11">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Degree')}}</label>
                                            <input type="text" value="{{ $education->degree }}" required name="degree[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('College/Institute')}}</label>
                                            <input type="text" value="{{ $education->college }}" required name="college[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Year of Completion')}}</label>
                                            <input type="text" maxlength="4" value="{{ $education->year }}" pattern="^[0-9]{4}$" required name="year[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($loop->iteration != 1)
                            <div class="col-12 col-md-2 col-lg-1">
                                <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                <a href="javascript:void(0)" class="btn btn-danger trash">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <div class="row form-row education-cont">
                            <div class="col-12 col-md-10 col-lg-11">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Degree')}}</label>
                                            <input type="text" required name="degree[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('College/Institute')}}</label>
                                            <input type="text" required name="college[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Year of Completion')}}</label>
                                            <input type="text" maxlength="4" pattern="^[0-9]{4}$" required name="year[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="add-more">
                        <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i>{{__('Add
                            More')}}</a>
                    </div>
                </div>

                <div class="form-group">
                    <div class="awards-info">
                        @if (json_decode($doctor->certificate))
                        @foreach (json_decode($doctor->certificate) as $certificate)
                        <div class="row form-row awards-cont">
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    <label>{{__('certificate')}}</label>
                                    <input type="text" value="{{ $certificate->certificate }}" required name="certificate[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    <label>{{__('Year')}}</label>
                                    <input type="text" required value="{{ $certificate->certificate_year }}" name="certificate_year[]" maxlength="4" pattern="^[0-9]{4}$" class="form-control">
                                </div>
                            </div>
                            @if ($loop->iteration != 1)
                            <div class="col-12 col-md-2">
                                <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                <a href="javascript:void(0)" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <div class="row form-row awards-cont">
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    <label>{{__('certificate')}}</label>
                                    <input type="text" required name="certificate[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    <label>{{__('Year')}}</label>
                                    <input type="text" required name="certificate_year[]" maxlength="4" pattern="^[0-9]{4}$" class="form-control">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="add-more">
                        <a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i>{{__('Add
                            More')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-primary">
                {{__('Other information')}}
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Experience (in years)')}}</label>
                        <input type="number" name="experience" value="{{ $doctor->experience }}" class="form-control @error('experience') is-invalid @enderror">
                        @error('number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Appointment fees')}}</label>
                        <input type="number" name="appointment_fees" value="{{ $doctor->appointment_fees }}" class="form-control @error('appointment_fees') is-invalid @enderror">
                        @error('appointment_fees')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-4 form-group">
                        <label class="col-form-label">{{__('Treatments')}}</label>
                        <select name="treatment_id" class="select2 @error('treatment_id') is-invalid @enderror">
                            @foreach ($treatments as $treatment)
                            <option value="{{ $treatment->id }}" {{ $doctor->treatment_id == $treatment->id ? 'selected'
                                : '' }}>{{ $treatment->name }}</option>
                            @endforeach
                        </select>
                        @error('treatment_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4 form-group">
                        <label class="col-form-label">{{__('Categories')}}</label>
                        <select name="category_id" class="select2 @error('category_id') is-invalid @enderror">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $doctor->category_id == $category->id ? 'selected' :
                                '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4 form-group">
                        <label class="col-form-label">{{__('Expertise')}}</label>
                        <select name="expertise_id" class="select2 @error('expertise_id') is-invalid @enderror">
                            @foreach ($expertieses as $experties)
                            <option value="{{ $experties->id }}" {{ $doctor->expertise_id == $experties->id ? 'selected'
                                : '' }}>{{ $experties->name }}</option>
                            @endforeach
                        </select>
                        @error('expertise_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Timeslots(In minutes)')}}</label>
                        <select name="timeslot" class="form-control @error('timeslot') is-invalid @enderror">
                            <option value="15" {{ $doctor->timeslot == 15 ? 'selected' : '' }}>15</option>
                            <option value="30" {{ $doctor->timeslot == 30 ? 'selected' : '' }}>30</option>
                            <option value="45" {{ $doctor->timeslot == 45 ? 'selected' : '' }}>45</option>
                            <option value="60" {{ $doctor->timeslot == 60 ? 'selected' : '' }}>60</option>
                            <option value="90" {{ $doctor->timeslot == 90 ? 'selected' : '' }}>90</option>
                            <option value="other" {{ $doctor->timeslot == 'other' ? 'selected' : '' }}>{{__('Other')}}
                            </option>
                        </select>
                        @error('timeslot')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Based On')}}</label>
                        <select name="based_on" disabled class="form-control @error('based_on') is-invalid @enderror">
                            <option value="subscription" {{ $doctor->based_on == 'subscription' ? 'selected' : ''
                                }}>{{__('subscription')}}</option>
                            <option value="commission" {{ $doctor->based_on == 'commission' ? 'selected' : ''
                                }}>{{__('commission')}}</option>
                        </select>
                        @error('based_on')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6  form-group custom_timeslot {{ $doctor->timeslot != 'other' ? 'hide' : '' }}">
                        <label class="col-form-label">{{__('Add timeslot value(In minutes)')}}</label>
                        <input type="number" name="custom_timeslot" value="{{ $doctor->custom_timeslot }}" class="form-control custom_timeslot_text @error('custom_timeslot') is-invalid @enderror">
                        @error('custom_timeslot')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group base_on_com {{ $doctor->based_on != 'commission' ? 'hide' : '' }}">
                        <label class="col-form-label">{{__('Commission Amount ( pr appointment ) ( in % )')}}</label>
                        <input type="text" step="any" name="commission_amount" disabled {{ $doctor->based_on == 'commission_amount'
                        ? 'required' : '' }} value="{{ $doctor->commission_amount }}" class="form-control
                        base_on_com_text @error('commission_amount') is-invalid @enderror">
                        @error('commission_amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Start Time')}}</label>
                        <input class="form-control timepicker @error('start_time') is-invalid @enderror" value="{{ $doctor->start_time }}" name="start_time" type="time">
                        @error('start_time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('End Time')}}</label>
                        <input class="form-control timepicker @error('end_time') is-invalid @enderror" value="{{ $doctor->end_time }}" name="end_time" type="time">
                        @error('end_time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-right p-2">
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </div>
        </div>
    </form>
</section>
@endsection

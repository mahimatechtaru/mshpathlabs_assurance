@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title',__('Add Doctor'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Doctor'),
        'url' => url('doctor'),
        'urlTitle' =>  __('Doctor'),
    ])
    @if (session('status'))
        @include('superAdmin.auth.status',['status' => session('status')])
    @endif

    <div class="section_body">
        <form action="{{ url('doctor') }}" method="post" enctype="multipart/form-data" class="myform">
            @csrf
            <div class="card">
                <div class="card-header text-primary">
                    {{__('personal information')}}
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-lg-2 col-md-4">
                            <label for="Doctor_image" class="col-form-label"> {{__('Doctor image')}}</label>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview">
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
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('email')}}</label>
                                <input type="email"  name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
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
                            <div class="d-flex @error('phone') is-invalid @enderror">
                                <select name="phone_code" class="phone_code_select2" value="{{ old('phone_code') }}">
                                    @foreach ($countries as $country)
                                        <option value="+{{$country->phonecode}}" {{(old('phone_code') == $country->phonecode) ? 'selected':''}}>+{{ $country->phonecode }}</option>
                                    @endforeach
                                </select>
                                <input type="number" min="1" name="phone" class="form-control" value="{{old('phone')}}" required>
                            </div>
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Hospital')}}</label>
                            <select name="hospital_id[]" class="select2 @error('hospital_id') is-invalid @enderror" multiple required>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{in_array($hospital->id, old("hospital_id") ?: []) ? "selected" : ""}}>{{ $hospital->name }}</option>
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
                            <input type="text" class="form-control datePicker @error('dob') is-invalid @enderror" value="{{old('dob')}}" name="dob" required>
                            @error('dob')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label">{{__('Gender')}}</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" >
                                <option value="male" {{ old('gender') == "male" ? 'selected' : '' }}>{{__('male')}}</option>
                                <option value="female" {{ old('gender') == "female" ? 'selected' : '' }}>{{__('female')}}</option>
                                <option value="other" {{ old('gender') == "other" ? 'selected' : '' }}>{{__('other')}}</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12 form-group">
                            <label class="col-form-label">{{__('Professional Bio')}}</label>
                            <textarea name="desc" rows="10" cols="10"  class="form-control @error('desc') is-invalid @enderror" required>{{old('desc')}}</textarea>
                            @error('desc')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
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
                            <div class="row form-row education-cont">
                                <div class="col-12 col-md-10 col-lg-11">
                                    <div class="row form-row">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Degree')}}</label>
                                                <input type="text"  required name="degree[]" value="" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('College/Institute')}}</label>
                                                <input type="text" required name="college[]" value="" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Year of Completion')}}</label>
                                                <input type="text" maxlength="4" pattern="^[0-9]{4}$"  required name="year[]" value="" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i>{{__('Add More')}}</a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="awards-info">
                                <div class="row form-row awards-cont">
                                    <div class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label>{{__('certificate')}}</label>
                                            <input type="text"  required name="certificate[]" value="" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label>{{__('Year')}}</label>
                                            <input type="text" required  name="certificate_year[]" maxlength="4" value="" pattern="^[0-9]{4}$" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-more">
                                <a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i> {{__('Add More')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-primary">
                    {{__('Other information')}}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Experience (in years)')}}</label>
                        <input type="number" min="1" name="experience" value="{{ old('experience') }}"  class="form-control @error('experience') is-invalid @enderror" required>
                        @error('number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Appointment fees')}}</label>
                        <input type="number" min="1" name="appointment_fees" value="{{ old('appointment_fees') }}"  class="form-control @error('appointment_fees') is-invalid @enderror" required>
                        @error('appointment_fees')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-4 form-group">
                            <label class="col-form-label">{{__('Treatments')}}</label>
                            <select name="treatment_id" class="select2 @error('treatment_id') is-invalid @enderror">
                                @foreach ($treatments as $treatment)
                                    <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
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
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                    <option value="{{ $experties->id }}">{{ $experties->name }}</option>
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
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                                <option value="60">60</option>
                                <option value="90">90</option>
                                <option value="other">{{__('Other')}}</option>
                            </select>
                            @error('timeslot')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Based On')}}</label>
                            <select name="based_on" class="form-control @error('based_on') is-invalid @enderror">
                                <option value="subscription" {{ old('based_on') == "subscription" ? 'selected' : '' }}>{{__('subscription')}}</option>
                                <option value="commission" {{ old('based_on') == "commission" ? 'selected' : '' }}>{{__('commission')}}</option>
                            </select>
                            @error('based_on')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 form-group custom_timeslot hide">
                            <label class="col-form-label">{{__('Add timeslot value(In minutes)')}}</label>
                            <input type="number" min="1" value="{{ old('timeslot') }}" class="form-control custom_timeslot_text @error('timeslot') is-invalid @enderror">
                            @error('timeslot')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group base_on_com hide">
                            <label class="col-form-label">{{__('Commission Amount ( pr appointment ) ( in % )')}}</label>
                            <input type="number" min="1" step="any" value="{{ old('commission_amount') }}" name="commission_amount" class="form-control base_on_com_text @error('commission') is-invalid @enderror">
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
                            <input class="form-control timepicker @error('start_time') is-invalid @enderror"  name="start_time" value="{{old('start_time')}}" type="time" required>
                            @error('start_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('End Time')}}</label>
                            <input class="form-control timepicker @error('end_time') is-invalid @enderror" name="end_time"  value="{{old('end_time')}}" type="time" required>
                            @error('end_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 form-group    ">
                            <label class="col-form-label">{{__('Popular ?')}}</label>
                            <select name="is_popular" class="form-control">
                                <option value="1" {{ old('is_popular') == "1" ? 'selected' : '' }}>{{__('yes')}}</option>
                                <option value="0" {{ old('is_popular') == "0" ? 'selected' : '' }}>{{__('no')}}</option>
                            </select>
                            @error('is_popular')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Password')}}</label>
                            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('Leave empty to auto-generate')}}">
                            @error('password')
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
    </div>
</section>

@endsection


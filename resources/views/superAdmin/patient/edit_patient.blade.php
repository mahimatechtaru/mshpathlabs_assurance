@extends('layout.mainlayout_admin',['activePage' => 'patients'])

@section('title',__('Edit patient'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Patient'),
        'url' => url('patient'),
        'urlTitle' => __('Patient'),
    ])
    <div class="section_body">
        <div class="card">
            <form action="{{ url('patient/'.$patient->id) }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-lg-2 col-md-4">
                            <label for="patient_image" class="ul-form__label"> {{__('patient image')}}</label>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $patient->fullImage }});">
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
                                <input type="text" value="{{ $patient->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('email')}}</label>
                                <input type="email" readonly value="{{ $patient->email }}" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-2 form-group">
                            <label for="phone_number" class="col-form__label"> {{__('Phone Code')}}</label><br>
                            <select name="phone_code" class="form-control phone_code_select2">
                                @foreach ($countries as $country)
                                    <option value="+{{$country->phonecode}}" {{ old('phone_code',$patient->phone_code) == $country->phonecode ? 'selected' : '' }}>+{{ $country->phonecode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-10 form-group">
                            <label for="phone_number" class="col-form-label"> {{__('Phone Number')}}</label>
                            <input type="number" min="1" value="{{ old('phone',$patient->phone) }}" name="phone" class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 from-group">
                            <label for="col-form-group">{{__('Date of birth')}}</label>
                            <input type="text" value="{{$patient->dob}}" class="form-control datePicker @error('dob') is-invalid @enderror" name="dob">
                            @error('dob')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 from-group">
                            <label for="col-from-group">{{__('Gender')}}</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>{{__('male')}}</option>
                                <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>{{__('female')}}</option>
                                <option value="other" {{ $patient->other == 'other' ? 'selected' : '' }}>{{__('other')}}</option>
                            </select>
                            @error('gender')
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
            </form>
        </div>
    </div>
</section>

@endsection

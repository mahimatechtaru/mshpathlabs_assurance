@extends('layout.mainlayout_admin',['activePage' => 'offer'])

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
@endsection

@section('title',__('Add offer'))

@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Offer'),
        'url' => url('offer'),
        'urlTitle' => __('Offer'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif
    <div class="section_body">
        <div class="card">
            <form action="{{ url('offer') }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-lg-2 col-md-4">
                            <label for="offer_image" class="ul-form__label"> {{__('Offer image')}}</label>
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
                                <label class="col-form-label">{{__('Offer name')}}</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('Offer Code')}}</label>
                                <input type="text" value="{{ old('offer_code') }}" name="offer_code" class="form-control @error('offer_code') is-invalid @enderror">
                                @error('offer_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Available for this doctor')}}</label>
                            <select name="doctor_id[]" class="form-control select2 @error('doctor_id') is-invalid @enderror" multiple>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" selected>{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Available for this patient')}}</label>
                            <select name="user_id[]" class="form-control select2 @error('user_id') is-invalid @enderror" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-3 form-group">
                            <label for="start_end_date">{{__('start & end date')}}</label>
                            <input type="text" name="start_end_date" class="form-control date_range">
                        </div>
                        <div class="col-lg-3 form-group">
                            <input type="checkbox" id="chkbox" name="is_flat"  {{ old('is_flat') == 1 ? 'checked' : ''  }} value="1" >
                            <label for="chkbox">{{__('Flat Discount')}}</label>
                        </div>
                        <div class="col-lg-6  form-group flatDiscCol {{ old('is_flat') != 1 ? 'hide' : ''  }}">
                            <label for="chkbox">{{__('Flat Discount')}}</label>
                            <input type="number" min="1" name="flatDiscount" value="{{ old('flatDiscount') }}" class="form-control">
                        </div>
                        <div class="col-lg-6  form-group discountCol {{ old('is_flat') == 1 ? 'hide' : ''  }}">
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label for="chkbox">{{__('Discount type')}}</label>
                                    <select name="discount_type" class="form-control">
                                        <option value="amount">{{__('amount')}}</option>
                                        <option value="percentage">{{__('percentage')}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label for="chkbox">{{__('Discount amount')}}</label>
                                    <input type="number" min="1" name="discount" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Maximum use')}}</label>
                            <input type="number" min="1" value="{{ old('max_use') }}" name="max_use" class="form-control @error('max_use') is-invalid @enderror">
                            @error('max_use')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Maximum Discount amount')}}</label>
                            <input type="number" min="1" value="{{ old('min_discount') }}" name="min_discount" class="form-control @error('min_discount') is-invalid @enderror">
                            @error('min_discount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Description')}}</label>
                        <textarea name="desc" rows="10" cols="30" class="form-control @error('desc') is-invalid @enderror">{{ old('desc') }}</textarea>
                        @error('desc')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-right mt-4">
                            <input type="submit" value="submit" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
@section('js')
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
@endsection

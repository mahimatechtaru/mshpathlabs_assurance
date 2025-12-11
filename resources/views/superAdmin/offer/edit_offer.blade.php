@extends('layout.mainlayout_admin',['activePage' => 'offer'])

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
@endsection

@section('title',__('Edit offer'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Offer'),
        'url' => url('offer'),
        'urlTitle' => __('Offer'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="card">
        <form action="{{ url('offer/'.$offer->id) }}" method="post" enctype="multipart/form-data" class="myform">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-lg-2 col-md-4">
                        <label for="offer_image" class="col-form-label"> {{__('Offer image')}}</label>
                        <div class="avatar-upload avatar-box avatar-box-left">
                            <div class="avatar-edit">
                                <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                <label for="image"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{ $offer->fullImage }});">
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
                            <input type="text" value="{{ $offer->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">{{__('Offer code')}}</label>
                            <input type="text" value="{{ $offer->offer_code }}" name="offer_code" class="form-control @error('offer_code') is-invalid @enderror">
                            @error('offer_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Available for this doctor')}}</label>
                        <select name="doctor_id[]" class="form-control select2" multiple>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{in_array($doctor->id,explode(',',$offer->doctor_id)) ? 'selected' : ''}}>{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Available for this patient')}}</label>
                        <select name="user_id[]" class="form-control select2" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{in_array($user->id,explode(',',$offer->user_id)) ? 'selected' : ''}}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-3 form-group">
                        <label for="start_end_date">{{__('start & end date')}}</label>
                        <input type="text" id="update_start_end_date" name="update_start_end_date" value="{{ $offer->start_end_date }}" class="form-control date_range">
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="checkbox" id="chkbox" name="is_flat" {{$offer->is_flat == 1 ? 'checked' : ''}}>
                        <label for="chkbox">{{__('Flat Discount')}}</label>
                    </div>
                    <div class="col-lg-6  form-group flatDiscCol {{ $offer->is_flat != 1 ? 'hide' : '' }}">
                        <label for="chkbox">{{__('Flat Discount')}}</label>
                        <input type="number" min="1" name="flatDiscount" value="{{ $offer->flatDiscount }}" class="form-control">
                    </div>
                    <div class="col-lg-6 discountCol {{ $offer->is_flat == 1 ? 'hide' : '' }}">
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label for="chkbox">{{__('Discount type')}}</label>
                                <select name="discount_type" class="form-control">
                                    <option value="amount" {{ $offer->discount_type == 'amount' ? 'selected' : '' }}>{{__('amount')}}</option>
                                    <option value="percentage" {{ $offer->discount_type == 'percentage' ? 'selected' : '' }}>{{__('percentage')}}</option>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="chkbox">{{__('Discount amount')}}</label>
                                <input type="number" step="any" min="1" name="discount" value="{{ $offer->discount }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Maximum use')}}</label>
                        <input type="number" min="1" value="{{ $offer->max_use }}" name="max_use" class="form-control @error('max_use') is-invalid @enderror">
                        @error('max_use')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 form-group">
                        <label class="col-form-label">{{__('Maximum Discount amount')}}</label>
                        <input type="number" step="any" min="1" value="{{ $offer->min_discount }}" name="min_discount" class="form-control @error('min_discount') is-invalid @enderror">
                        @error('min_discount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Description')}}</label>
                    <textarea name="desc" rows="10" cols="30" class="form-control @error('desc') is-invalid @enderror">{{ $offer->desc }}</textarea>
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
</section>

@endsection
@section('js')
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
@endsection

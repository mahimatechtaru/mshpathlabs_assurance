@extends('layout.mainlayout_admin',['activePage' => 'medicine'])

@section('title',__('Add Medicine'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add medicine'),
        'url' => url('medicines'),
        'urlTitle' => __('Medicine')
    ])
    <form action="{{ url('medicines') }}" method="post" enctype="multipart/form-data" class="myform">
        @csrf
        <input type="hidden" name="pharmacy_id" value="{{ $pharmacy->id }}">
        <div class="card">
            <input type="hidden" name="pharmacy_id" value="{{ $pharmacy->id }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        <label for="category_image" class="ul-form__label"> {{__('Medicine image')}}</label>
                    </div>
                    <div class="col-lg-2 col-md-4">
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
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">{{__('Price')}}({{__('Per Strip')}})</label>
                            <input type="number" min="1" value="{{ old('price_pr_strip') }}" name="price_pr_strip" class="form-control @error('price_pr_strip') is-invalid @enderror">
                            @error('price_pr_strip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Number of medicines in strip')}}</label>
                    <input type="number" min="1" value="{{ old('number_of_medicine') }}" name="number_of_medicine" class="form-control @error('number_of_medicine') is-invalid @enderror">
                    @error('number_of_medicine')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Incoming Stock')}}</label>
                    <input type="number" value="{{ old('incoming_stock') }}" name="incoming_stock" class="form-control @error('incoming_stock') is-invalid @enderror">
                    @error('incoming_stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Medicine Category')}}</label>
                    <select name="medicine_category_id" class="select2 @error('medicine_category_id') is-invalid @enderror">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('medicine_category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Description')}}</label>
                    <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror"></textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('How It Works??')}}</label>
                    <textarea name="works" class="form-control summernote @error('works') is-invalid @enderror"></textarea>
                    @error('works')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Is Prescription compulsory?')}}</label>
                    <select name="prescription_required" class="form-control">
                        <option value="1">{{__('Yes')}}</option>
                        <option value="0">{{__('No')}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('status')}}</label>
                    <select name="status" class="form-control">
                        <option value="1">{{__('Active')}}</option>
                        <option value="0">{{__('Deactive')}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>{{__('Add more Information')}}</h4>
                <a href="javascript:void(0);" class="add-moreInfo float-right">
                    <i class="fa fa-plus-circle"></i>{{__('Add Field')}}
                </a>
            </div>
            <div class="card-body moreInfo">

            </div>
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </div>
        </div>
    </form>
</section>
@endsection

@extends('layout.mainlayout_admin',['activePage' => 'medicine'])

@section('title',__('Edit Medicine'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Medicine'),
        'url' => url('pharmacy'),
        'url1' => url('pharmacy/'.$pharmacy->id),
        'urlTitle1' => $pharmacy->name,
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('medicine/'.$medicine->id) }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-4">
                            <label for="category_image" class="ul-form__label"> {{__('Medicine image')}}</label>
                        </div>
                        <div class="col-lg-12 col-md-8">
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $medicine->fullImage }});">
                                    </div>
                                </div>
                            </div>
                            @error('image')
                                <div class="custom_error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <label class="col-form-label">{{__('Name')}}</label>
                            <div class="form-group">
                                <input type="text" value="{{ $medicine->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label class="col-form-label">{{__('Price')}}({{__('Per Strip')}})</label>
                            <div class="form-group">
                                <input type="number" min="1" value="{{ $medicine->price_pr_strip }}" name="price_pr_strip" class="form-control @error('price_pr_strip') is-invalid @enderror">
                                @error('price_pr_strip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <label class="col-form-label">{{__('Number of medicines in strip')}}</label>
                            <div class="form-group">
                                <input type="number" min="1" value="{{ $medicine->number_of_medicine }}" name="number_of_medicine" class="form-control @error('number_of_medicine') is-invalid @enderror">
                                @error('number_of_medicine')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="col-form-label">{{__('Medicine Category')}}</label>
                            <select name="medicine_category_id" class="select2 @error('medicine_category_id') is-invalid @enderror">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{ $category->id == $medicine->medicine_category_id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('medicine_category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <label class="col-form-label">{{__('Description')}}</label>
                            <div class="form-group">
                                <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror">{{ $medicine->description }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <label class="col-form-label">{{__('How It Works??')}}</label>
                            <div class="form-group">
                                <textarea name="works" class="form-control summernote @error('works') is-invalid @enderror">{{ $medicine->works }}</textarea>
                                @error('works')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <label for="">{{__('Is Prescription compulsory?')}}</label>
                        </div>
                        <div class="col-lg-12">
                            <select name="prescription_required" class="form-control">
                                <option value="1" {{ $medicine->prescription_required == 1 ? 'selected' : '' }}>{{__('Yes')}}</option>
                                <option value="0" {{ $medicine->prescription_required == 0 ? 'selected' : '' }}>{{__('No')}}</option>
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
                        @if(isset($medicine->meta_info))
                            @foreach (json_decode($medicine->meta_info) as $item)
                                <div class="moreInfoDiv">
                                    <label class="col-form-label">{{__('Title')}}</label>
                                    <div class="form-group">
                                        <input type="text" name="title[]" value="{{ $item->title }}" required class="form-control">
                                    </div>
                                    <label class="col-form-label">{{__('Description')}}</label>
                                    <div class="form-group">
                                        <textarea name="desc[]" required class="form-control summernote">{{ $item->desc }}</textarea>
                                    </div>
                                    <a  href="javascript:void(0);" class="btn btn-danger text-white moreDelete"><i class="far fa-trash-alt"></i></a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

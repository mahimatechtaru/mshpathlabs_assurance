@extends('layout.mainlayout_admin',['activePage' => 'category'])

@section('title',__('Edit Category'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Category'),
        'url' => url('category'),
        'urlTitle' => __('Category'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif
    <div class="section_body">
        <div class="card">
            <form action="{{ url('category/'.$category->id) }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <label for="app_id" class="col-form-label"> {{__('Category image')}}</label>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $category->fullImage }});">
                                    </div>
                                </div>
                            </div>
                            @error('image')
                                <div class="custom_error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-10 col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Name')}}</label>
                                <input type="text" value="{{ $category->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('Treatments')}}</label>
                                <select name="treatment_id" class="select2">
                                    @foreach ($treats as $treat)
                                        <option value="{{ $treat->id }}" {{ $treat->id == $category->treatment_id ? 'selected' : '' }}>{{ $treat->name }}</option>
                                    @endforeach
                                </select>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@extends('layout.mainlayout_admin',['activePage' => 'banner'])

@section('title',__('Edit Banner'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Banner'),
        'url' => url('banner'),
        'urlTitle' => __('Banner'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <form action="{{ url('banner/'.$banner->id) }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-4">
                            <label for="banner_image" class="ul-form__label"> {{__('banner image')}}</label>
                        </div>
                        <div class="col-lg-12 col-md-8">
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $banner->fullImage }});">
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
                    <div class="form-group">
                        <label class="col-form-label">{{__('Banner name')}}</label>
                        <input type="text" value="{{ $banner->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Banner Description')}}</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" maxlength="255" rows="10" style="height: 80px;">{{ $banner->description }}</textarea>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Link')}}</label>
                        <input type="text" value="{{ $banner->link }}" name="link" class="form-control @error('link') is-invalid @enderror">
                        @error('link')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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

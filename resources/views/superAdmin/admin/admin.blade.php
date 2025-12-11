@extends('layout.mainlayout_admin',['activePage' => 'admin'])

@section('title',__('Admin Profile'))
@section('content')

<section class="section">

    @include('layout.breadcrumb',[
        'title' => __('Admin Profile'),
    ])

    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif
    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <form action="{{ url('update_profile') }}" method="post" enctype="multipart/form-data" class="myform">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-4">
                            <label for="category_image" class="ul-form__label"> {{__('Admin image')}}</label>
                        </div>
                        <div class="col-lg-12 col-md-8">
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $user->fullImage }});">
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
                        <label class="col-form-label">{{__('Name')}}</label>
                        <input type="text" value="{{ $user->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Email')}}</label>
                        <input type="email" value="{{ $user->email }}" name="email" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <input type="submit" value="{{__('submit')}}" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>{{__('change password')}}</strong>
        </div>
        <div class="card-body">
            <form action="{{ url('change_password') }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                <div class="form-group">
                    <label class="col-form-label">{{__('Old password')}}</label>
                    <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror">
                    @error('old_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('New password')}}</label>
                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                    @error('new_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Confirm New password')}}</label>
                    <input type="password" name="confirm_new_password" class="form-control @error('confirm_new_password') is-invalid @enderror">
                    @error('confirm_new_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="row">
                <div class="col-md-12 text-right">
                    <input type="submit" value="{{__('submit')}}" class="btn btn-primary">
                </div>
            </form>
            </div>
        </div>
    </div>
</section>

@endsection

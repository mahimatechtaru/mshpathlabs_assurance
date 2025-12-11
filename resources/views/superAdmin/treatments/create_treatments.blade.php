@extends('layout.mainlayout_admin',['activePage' => 'treatments'])

@section('title',__('Add Treatments'))
@section('content')
    <section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Add Treatments'),
            'url' => url('treatments'),
            'urlTitle' => __('Treatments'),
        ])
        <div class="section-body">
            <div class="card">
                <form action="{{ url('treatments') }}" method="post" enctype="multipart/form-data" class="myform">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-6">
                                <label for="app_id" class="ul-form__label"> {{__('Treatment image')}}</label>
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
                            <div class="col-lg-10 col-md-6">
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
                                    <label for="col-form-label">{{__('status')}}</label>
                                    <label class="cursor-pointer">
                                        <input type="checkbox" id="status" class="custom-switch-input" name="status">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
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

@extends('layout.mainlayout_admin',['activePage' => 'language'])

@section('title',__('Add Language'))

@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Language'),
        'url' => url('language'),
        'urlTitle' => __('Language')
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
        <div class="card">
            <form action="{{ url('language') }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-lg-2 col-md-4">
                            <label for="language_image" class="ul-form__label"> {{__('Language image')}}</label>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" data-id="add"/>
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
                                <label class="col-form-label">{{__('Language Name')}}</label>
                                <input type="text" value="{{ old('name') }}" name="name" required class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('Language Json File')}}</label>
                                <input type="file" value="{{ old('json_file') }}" name="json_file" accept=".json"  required class="form-control @error('json_file') is-invalid @enderror">
                                @error('json_file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label class="col-form-label">{{__('Language Direction')}}</label>
                        <select name="direction" class="form-control">
                            <option value="ltr">{{__('Ltr')}}</option>
                            <option value="rtl">{{__('Rtl')}}</option>
                        </select>
                        @error('direction')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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

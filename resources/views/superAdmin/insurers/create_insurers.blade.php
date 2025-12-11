@extends('layout.mainlayout_admin',['activePage' => 'insurers'])

@section('title',__('Add Insurers'))
@section('content')
    <section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Add Insurers'),
            'url' => url('insurers'),
            'urlTitle' => __('Insurers'),
        ])
        <div class="section-body">
            <div class="card">
                <form action="{{ url('insurers') }}" method="post" class="myform">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Name')}}</label>
                                    <input type="text" value="{{ old('name') }}" maxlength="100" name="name" class="form-control @error('name') is-invalid @enderror" required>
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

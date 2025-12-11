@extends('layout.mainlayout_admin',['activePage' => 'subscription'])

@section('title',__('Add subscription'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Subscription'),
        'url' => url('subscription'),
        'urlTitle' => __('Subscription'),
    ])
    <div class="card">
        <form action="{{ url('subscription') }}" method="post" class="myform">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label">{{__('Subscription plan name')}}</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Available Total appointments')}}</label>
                    <input type="number" min="1" value="{{ old('total_appointment') }}" name="total_appointment" class="form-control @error('total_appointment') is-invalid @enderror">
                    @error('total_appointment')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <label class="col-form-label">{{__('Subscription plan validity and price')}}</label>
                <div class="registrations-info mt-3">
                    <div class="row form-row reg-cont">
                        <div class="col-12 col-md-5 form-group">
                            <label class="col-form-group">{{__('Month')}}</label>
                            <input type="number" min="1" name="month[]" required class="form-control">
                        </div>
                        <div class="col-12 col-md-5 form-group">
                            <label>{{__('price')}}</label>
                            <input type="number" min="1" name="price[]" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-reg"><i class="fa fa-plus-circle"></i>{{__('Add More')}}</a>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
        </form>
    </div>
</section>

@endsection

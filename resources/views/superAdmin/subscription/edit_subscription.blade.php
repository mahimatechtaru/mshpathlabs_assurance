@extends('layout.mainlayout_admin',['activePage' => 'subscription'])

@section('title',__('Edit Subscription'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Subscription'),
        'url' => url('subscription'),
        'urlTitle' => __('Subscription'),
    ])
    <div class="card">
        <form action="{{ url('subscription/'.$subscription->id) }}" method="post" class="myform">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label">{{__('Subscription plan name')}}</label>
                    @if($subscription->name == "free")
                        <input type="text" value="{{ $subscription->name }}" name="name" class="form-control @error('name') is-invalid @enderror" readonly>
                    @else
                        <input type="text" value="{{ $subscription->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                    @endif
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{__('Available Total appointments')}}</label>
                    <input type="number" min="1" value="{{ $subscription->total_appointment }}" name="total_appointment" class="form-control @error('total_appointment') is-invalid @enderror">
                    @error('total_appointment')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <label class="col-form-label">{{__('Subscription plan validity and price')}}</label>
                <div class="registrations-info mt-3">
                    @foreach (json_decode($subscription->plan) as $plan)
                        <div class="row form-row reg-cont">
                            <div class="col-12 col-md-5 form-group">
                                <label>{{__('Month')}}</label>
                                <input type="number" min="1" name="month[]" value="{{$plan->month}}" required class="form-control">
                            </div>
                            <div class="col-12 col-md-5 form-group">
                                <label>{{__('price')}}</label>
                                @if($subscription->name == "free")
                                    <input type="number" min="1" name="price[]" value="{{$plan->price}}" class="form-control" readonly>
                                @else
                                    <input type="number" min="1" name="price[]" value="{{$plan->price}}" class="form-control">
                                @endif
                            </div>
                            @if ($loop->iteration != 1)
                                <div class="col-12 col-md-2">
                                    <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                    <a href="javascript:void(0);" class="btn btn-danger trash">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($subscription->name == "free")
                    <div class="add-more d-none">
                        <a href="javascript:void(0);" class="add-reg"><i class="fa fa-plus-circle"></i>{{__('Add More')}}</a>
                    </div>
                @else
                    <div class="add-more">
                        <a href="javascript:void(0);" class="add-reg"><i class="fa fa-plus-circle"></i>{{__('Add More')}}</a>
                    </div>
                @endif
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
        </form>
    </div>
</section>

@endsection

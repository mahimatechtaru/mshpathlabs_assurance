@extends('layout.mainlayout_admin',['activePage' => 'insurers'])

@section('title',__('Edit Insurers'))
@section('content')
    <section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Edit Insurers'),
            'url' => url('insurers'),
            'urlTitle' => __('Insurers'),
        ])
        <div class="card">
            <form action="{{ url('insurers/'.$insurer->id) }}" method="post" class="myform">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Name')}}</label>
                                <input type="text" name="name" value="{{$insurer->name}}" class="form-control @error('name') is-invalid @enderror" required>
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
    </section>
@endsection

@extends('layout.mainlayout_admin',['activePage' => 'medicineCategory'])

@section('title',__('Add Medicine Category'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Medicine Category'),
        'url' => url('medicineCategory'),
        'urlTitle' => __('Medicine Category')
    ])
    <div class="section_body">
        <div class="card">
            <form action="{{ url('medicineCategory') }}" method="post" class="myform">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Name')}}</label>
                        <input type="text" required value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">{{__('status')}}</label>
                        <label class="cursor-pointer">
                            <input type="checkbox" id="status" class="custom-switch-input" name="status">
                            <span class="custom-switch-indicator"></span>
                        </label>
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

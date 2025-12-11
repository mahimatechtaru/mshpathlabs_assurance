@extends('layout.mainlayout_admin',['activePage' => 'medicineCategory'])

@section('title',__('Edit Medicne Category'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Medicine Category'),
        'url' => url('medicineCategory'),
        'urlTitle' => __('Medicine Category')
    ])
    <div class="section_body">
        <div class="card">
            <form action="{{ url('medicineCategory/'.$medicineCategory->id) }}" method="post" class="myform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Name')}}</label>
                        <input type="text" required value="{{ $medicineCategory->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
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

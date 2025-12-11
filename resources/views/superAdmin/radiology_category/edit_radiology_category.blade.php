@extends('layout.mainlayout_admin',['activePage' => 'radiology_category'])

@section('title',__('Radiology Category'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Radiology Category'),
        'url' => url('radiology_category'),
        'urlTitle' => __('Radiology Category'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('radiology_category/'.$radiology_category->id) }}" method="post" class="myform" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Radiology Category Name')}}</label>
                        <input type="text" required value="{{ old('name',$radiology_category->name) }}" name="name" class="form-control @error('name') is-invalid @enderror">
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

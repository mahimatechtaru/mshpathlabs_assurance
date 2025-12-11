@extends('layout.mainlayout_admin',['activePage' => 'pathology_category'])

@section('title',__('Pathology Category'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Pathology Category'),
        'url' => url('pathology_category'),
        'urlTitle' => __('Pathology Category'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('pathology_category/'.$pathology_category->id) }}" method="post" enctype="multipart/form-data" class="myform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Pathology Category Name')}}</label>
                        <input type="text" required value="{{ old('name',$pathology_category->name) }}" name="name" class="form-control @error('name') is-invalid @enderror">
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

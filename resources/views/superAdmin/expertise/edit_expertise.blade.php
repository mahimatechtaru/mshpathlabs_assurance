@extends('layout.mainlayout_admin',['activePage' => 'expertise'])

@section('title',__('Edit Expertise'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Expertise'),
        'url' => url('expertise'),
        'urlTitle' => __('Expertise')
    ])
    <div class="section_body">
        <div class="card">
            <form action="{{ url('expertise/'.$expertise->id) }}" method="post" class="myform">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Name')}}</label>
                        <input type="text" value="{{ $expertise->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Categories')}}</label>
                        <select name="category_id" class="select2 @error('category_id') is-invalid @enderror">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $expertise->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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

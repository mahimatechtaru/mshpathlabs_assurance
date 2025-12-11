@extends('layout.mainlayout_admin',['activePage' => 'expertise'])

@section('title',__('Add Expertise'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Expertise'),
        'url' => url('expertise'),
        'urlTitle' => __('Expertise')
    ])
        <div class="card">
            <form action="{{ url('expertise') }}" method="post" class="myform">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Name')}}</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Categories')}}</label>
                                <select name="category_id" class="select2 @error('category_id') is-invalid @enderror">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
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
</section>
@endsection

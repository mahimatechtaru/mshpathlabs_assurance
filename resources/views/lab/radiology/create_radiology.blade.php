@extends('layout.mainlayout_admin',['activePage' => 'radiology'])

@section('title',__('Radiology'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Radiology'),
        'url' => url('radiology'),
        'urlTitle' => __('Radiology'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('radiology') }}" method="post" class="myform">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('radiology category')}}</label>
                        <select name="radiology_category_id" class="form-control select2">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('method')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    @if (!auth()->user()->hasRole('laboratory') && Gate::check('radiology_access'))
                        <div class="form-group">
                            <label class="col-form-label">{{__('Laboratory')}}</label>
                            <select name="lab_id" class="form-control select2 @error('lab_id') is-invalid @enderror">
                                <option value="">{{ __('Select Laboratory') }}</option>
                                @foreach ($labs as $lab)
                                    <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                                @endforeach
                            </select>
                            @error('lab_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    @endif
                    @if (auth()->user()->hasRole('laboratory'))
                        <input type="hidden" name="lab_id" value="{{ $labs->id }}">
                    @endif
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="email" class="col-form-label"> {{__('report days')}}</label>
                            <input type="number" min="1" value="{{ old('report_days') }}" name="report_days" class="form-control @error('report_days') is-invalid @enderror">
                            @error('report_days')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="charge" class="col-form-label"> {{__('charge')}}</label>
                            <input type="number" min="1" value="{{ old('charge') }}" name="charge" class="form-control @error('charge') is-invalid @enderror">
                            @error('charge')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="charge" class="col-form-label"> {{__('Screening for')}}</label>
                            <input type="text" value="{{ old('screening_for') }}" name="screening_for" class="form-control @error('screening_for') is-invalid @enderror">
                            @error('screening_for')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

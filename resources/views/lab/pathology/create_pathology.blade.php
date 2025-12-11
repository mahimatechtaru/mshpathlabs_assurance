@extends('layout.mainlayout_admin',['activePage' => 'pathology'])

@section('title',__('Pathology'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Pathology'),
        'url' => url('pathology'),
        'urlTitle' => __('Pathology'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('pathology') }}" method="post" class="myform">
                @csrf
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Test Name')}}</label>
                                <input type="text" required value="{{ old('test_name') }}" name="test_name" class="form-control @error('test_name') is-invalid @enderror">
                                @error('test_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">{{__('method')}}</label>
                                <input type="text" value="{{ old('method') }}" name="method" class="form-control @error('method') is-invalid @enderror">
                                @error('method')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">{{__('pathology category')}}</label>
                                <select name="pathology_category_id" class="form-control select2">
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
                        </div>
                    </div>
                    @if (!auth()->user()->hasRole('laboratory') && Gate::check('pathology_access'))
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
                        <div class="col-md-4 form-group">
                            <label for="email" class="col-form-label"> {{__('report days')}}</label>
                            <input type="number" min="1" value="{{ old('report_days') }}" name="report_days" class="form-control @error('report_days') is-invalid @enderror">
                            @error('report_days')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="charge" class="col-form-label"> {{__('charge')}}</label>
                            <input type="number" min="1" value="{{ old('charge') }}" name="charge" class="form-control @error('charge') is-invalid @enderror">
                            @error('charge')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="test prescription required" class="col-form-label"> {{__('test prescription required')}}</label>
                            <select name="prescription_required" class="form-control @error('prescription_required') is-invalid @enderror">
                                <option value="1">{{ __('yes') }}</option>
                                <option value="0">{{ __('no') }}</option>
                            </select>
                            @error('prescription_required')
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

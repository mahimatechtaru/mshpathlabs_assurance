@extends('layout.mainlayout_admin',['activePage' => 'role'])

@section('title',__('Create Role'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Role'),
        'url' => url('role'),
        'urlTitle' => __('Role'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
        <div class="card">
            <form action="{{ url('role') }}" method="post" class="myform">
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

                    <div class="form-group">
                        <label class="col-form-label">{{__('Permissions')}}</label>
                        <select name="permissions[]" class="select2 @error('permissions') is-invalid @enderror" multiple="multiple">
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        @error('permissions')
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

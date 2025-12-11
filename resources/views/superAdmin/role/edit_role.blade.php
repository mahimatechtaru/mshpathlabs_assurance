@extends('layout.mainlayout_admin',['activePage' => 'role'])

@section('title',__('Edit Role'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Role'),
        'url' => url('role'),
        'urlTitle' => __('Role'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body">
        <div class="card">
            <form action="{{ url('role/'.$role->id) }}" method="post" class="myform">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Name')}}</label>
                        <input type="text" value="{{ $role->name }}" disabled name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('Permissions')}}</label>
                        <select name="permissions[]" class="@error('permissions') is-invalid @enderror" multiple="multiple" disabled>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) == 1 ? 'selected' : '' }}>{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        @error('permissions')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

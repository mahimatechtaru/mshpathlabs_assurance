@extends('layout.mainlayout_admin',['activePage' => 'admin'])

@section('title',__('Change Password'))
@section('content')
<section class="section">
        @include('layout.breadcrumb',[
            'title' => __('change password'),
        ])

        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                {{__('change password')}}
            </div>
            <div class="card-body">
                <form action="{{ url('change_password') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-form-label">{{__('Old password')}}</label>
                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror">
                        @error('old_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('New password')}}</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{__('Confirm New password')}}</label>
                        <input type="password" name="confirm_new_password" class="form-control @error('confirm_new_password') is-invalid @enderror">
                        @error('confirm_new_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                    <div class="col-md-12 text-right">
                        <input type="submit" value="{{__('submit')}}" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
</section>
@endsection

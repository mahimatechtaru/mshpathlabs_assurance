@extends('layout.mainlayout',['activePage' => 'login'])
@section('title',__('Forgot Password'))
@section('content')
<div class="xl:w-3/4 mx-auto">
        @if (session('status'))
         @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif

        @if(session('error'))
            @include('superAdmin.auth.errors',[
                'error' => session('error')])
        @endif

    <div class="flex justify-between items-center pt-20 pb-20 gap-10 lg:flex-row xxsm:flex-col xxsm:mx-5 xl:mx-0 2xl:mx-0">
        <div class="bg-slate-100 justify-center items-center p-10 2xl:w-2/4 xxsm:w-full">
            <h1 class="font-fira-sans leading-10 font-medium text-3xl mb-10">{{__('Talk to thousands of specialist doctors.')}}</h1>
            <div>
                <img src="{{asset('assets/image/login.png')}}" class="w-full h-3/5" alt="">
            </div>
        </div>
        <div class="2xl:w-2/4 xxsm:w-full">
            <h1 class="font-fira-sans leading-10 font-normal text-3xl">{{__('Welcome Back,')}}</h1>
            <h1 class="font-fira-sans leading-10 font-medium text-3xl">{{__('Forgot Password For Patient Account')}}</h1>
            <form action="{{ url('/user_forget_password') }}" method="post">
                @csrf
                <div class="pt-5">
                    <label for="email" class="font-fira-sans text-black text-sm font-normal">{{__('Email')}}</label>
                    <input name="email" class="@error('email') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter email')}}" required type="email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="pt-10">
                    <button type="submit" class="font-fira-sans text-white bg-primary w-full text-sm font-normal py-3">{{__('Send Email')}}</button>
                    <h1 class="font-fira-sans font-medium text-sm leading-5 pt-4 text-center text-primary text-normal"><a href="{{url('/patient-login')}}">{{__('Remember Password?')}} </a></h1>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

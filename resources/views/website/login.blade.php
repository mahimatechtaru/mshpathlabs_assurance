@extends('layout.mainlayout',['activePage' => 'login'])
@section('content')
<div class="xl:w-3/4 mx-auto">
    <div class="flex justify-between items-center pt-20 pb-20 gap-10 lg:flex-row xxsm:flex-col xxsm:mx-5 xl:mx-0 2xl:mx-0">
        <div class="bg-slate-100 justify-center items-center p-10 2xl:w-2/4 xxsm:w-full">
            <h1 class="font-fira-sans leading-10 font-medium text-3xl mb-10">{{__('Talk to thousands of specialist doctors.')}}</h1>
            <div>
                <img src="{{asset('assets/image/login.png')}}" class="w-full h-3/5" alt="">
            </div>
        </div>
        <div class="2xl:w-2/4 xxsm:w-full">
            <h1 class="font-fira-sans leading-10 font-normal text-3xl">{{__('Welcome Back,')}}</h1>
            <h1 class="font-fira-sans leading-10 font-medium text-3xl">{{__('Login to get started!')}}</h1>
            <form action="{{ url('patient-login') }}" method="post">
                @csrf
                <div class="pt-5">
                    <label for="email" class="font-fira-sans text-black text-sm font-normal">{{__('Email')}}</label>
                    <input type="text" name="email" class="@error('email') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter email')}}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="pt-3">
                    <label for="email" class="font-fira-sans text-black text-sm font-normal">{{__('Password')}}</label>
                    <input type="password" name="password" class="@error('password') is-invalid @enderror w-full text-sm font-fira-sans text-gray block p-2 z-20 border border-white-light" placeholder="{{__('Enter password')}}">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @if (session('error'))
                <div class="text-center">
                    <span class="custom_error  text-red font-fira-sans font-normal text-base mt-1">{{ session('error') }}</span>
                </div>
                @endif
                <div class="pt-10">
                    <button type="submit" class="font-fira-sans text-white bg-primary w-full text-sm font-normal py-3">{{__('Login')}}</button>
                </div>
                <div class="flex justify-between pt-4">
                    <div class="font-fira-sans font-medium text-sm leading-5 text-primary text-normal">
                        <a href="{{url('/doctor/doctor_login')}}">{{__('Doctor Login')}}</a>
                    </div>

                    <div class="font-fira-sans font-medium text-sm leading-5">{{__('Don’t have an account?  ')}} <a href="{{url('/signup')}}" class="text-primary text-normal">{{__('Signup')}}</a>
                    </div>
                    <div class="font-fira-sans font-medium text-sm leading-5 text-primary text-normal">
                        <a href="{{url('/forgot_password')}}">{{__('Forgot Password?')}}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
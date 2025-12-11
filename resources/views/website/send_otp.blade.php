@extends('layout.mainlayout',['activePage' => 'login'])

@section('css')
    <style>
        :root
        {
            --site_color: #1f8ced;
            --hover_color: #1f8cedc7;
        }
        .digit-group
        {
            text-align: center;
            display: flex;
        }
        .digit-group input
        {
            width: 60px;
            height: 68px !important;
            background-color: transparent;
            line-height: 50px;
            text-align: center;
            font-weight: 200;
            margin: 0 2px;
            border-radius: 24%;
            transition: all 0.2s ease-in-out;
            outline: none;
            border: solid 1px #ccc;
        }
        .digit-group input:focus
        {
            border-color: var(--site_color);
            box-shadow: 0 0 5px var(--hover_color) inset;
        }
        .digit-group input::selection
        {
            background: transparent;
        }
        .digit-group .splitter {
            padding: 0 5px;
            color: white;
            font-size: 24px;
        }
        .prompt {
            margin-bottom: 20px;
            font-size: 20px;
            color: white;
        }
    </style>
@endsection

@section('content')
    @if ($status && !$errors->any())
    @include('superAdmin.auth.status',[
        'status' => $status])
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $item)
            @include('superAdmin.auth.status',[
                'status' => $item])
        @endforeach
    @endif
<div class="container mx-auto py-20 mb-10 flex justify-evenly 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-col xsm:flex-col xxsm:flex-col">
    <div class="bg-slate-100 2xl:w-1/3 xl:w-1/3 xlg:w-1/3 lg:w-1/3 md:w-1/3 msm:w-full sm:w-1/3 justify-center items-center xsm:w-full p-5">
        <h1 class="font-fira-sans leading-10 font-medium text-3xl ">{{__('Talk to thousands of specialist doctors.')}}</h1>
        <div class="p-10">
            <img src="{{asset('assets/image/login.png')}}" class="w-full h-3/5" alt="">
        </div>
    </div>
    <div class="2xl:w-1/3 xl:w-1/3 xlg:w-1/3 lg:w-1/3 md:w-1/3 msm:w-full sm:w-1/3 xsm:w-full">
        <h1 class="font-fira-sans leading-10 font-normal text-3xl">{{__('Welcome Back,')}}</h1>
        <h1 class="font-fira-sans leading-10 font-medium text-3xl">{{__('Login to get started!')}}</h1>
        <form action="{{ ('verify_user') }}" method="post" class="pt-3 w-100">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="digit-group justify-around" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                <input type="text" required id="digit-1" name="digit_1" data-next="digit-2" />
                <input type="text" required id="digit-2" name="digit_2" data-next="digit-3" data-previous="digit-1" />
                <input type="text" required id="digit-3" name="digit_3" data-next="digit-4" data-previous="digit-2" />
                <input type="text" required id="digit-4" name="digit_4" data-next="digit-5" data-previous="digit-3" />
            </div>
            <div class="flex flex-col pt-0 Appointment-detail w-full mt-5">
                <a href="{{ url('send_otp') }}" class="text-primary text-right">{{ __('Send Again?') }}</a>
                <button type="submit" class="font-fira-sans text-white bg-primary w-full text-sm font-normal py-3" href="javascript:void(0)" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Submit</button>
            </div>

        </form>
    </div>

</div>

@endsection


@section('js')
<script src="{{ url('assets/js/jquery.min.js') }}"></script>
<script>
    $(function()
    {
        "use strict";
        $('.digit-group').find('input').each(function()
        {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e)
            {
                var parent = $($(this).parent());
                if(e.keyCode === 8 || e.keyCode === 37) {
                        var prev = parent.find('input#' + $(this).data('previous'));

                    if(prev.length) {
                        $(prev).select();
                    }
                } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));

                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });
    });
</script>
@endsection

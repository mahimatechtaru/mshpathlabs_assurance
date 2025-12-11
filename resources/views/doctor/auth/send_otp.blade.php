@extends('layout.mainlayout_admin',['activePage' => 'login'])

@section('title',__('Verified Doctor'))

<style>
    .digit-group {
        text-align: center;
        display: flex;
    }

    .digit-group input {
        width: 60px;
        height: 68px;
        background-color: transparent;
        line-height: 50px;
        text-align: center;
        font-weight: 200;
        margin: 0 2px;
        border-radius: 24%;
        transition: all 0.2s ease-in-out;
        /* border: none; */
        outline: none;
        border: solid 1px #ccc;
    }

    .digit-group input:focus {
        border-color: var(--primary_color);
        box-shadow: 0 0 5px var(--primary_color_hover) inset;
    }

    .digit-group input::selection {
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

@section('content')
<section class="section">
    <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
            <div class="p-4 m-3">
                @php
                $app_logo = App\Models\Setting::first();
                @endphp
                @if(isset($app_logo->logo))
                <img src="{{ $app_logo->logo }}" alt="logo" width="180" class="mb-5 mt-2">
                @else
                <img src="{{url('/images/upload_empty/logo_black.png')}}" class="h-6 mr-3 sm:h-9" alt="Doctro Logo" />
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('error')}}
                </div>
                @endif
                @if (!session('error'))
                @if ($status)
                @include('superAdmin.auth.status',[
                'status' => $status])
                @endif
                @endif
                <form action="{{ url('doctor/verify_otp') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                        <input type="text" required id="digit-1" name="digit_1" data-next="digit-2" />
                        <input type="text" required id="digit-2" name="digit_2" data-next="digit-3" data-previous="digit-1" />
                        <input type="text" required id="digit-3" name="digit_3" data-next="digit-4" data-previous="digit-2" />
                        <input type="text" required id="digit-4" name="digit_4" data-next="digit-5" data-previous="digit-3" />
                    </div>
                    <div class="form-group mt-5">
                        <button class="btn btn-primary btn-block" type="submit">{{__('verify')}}</button>
                    </div>
                </form>
                <div class="text-muted text-center">
                    {{__("Don't Send A Code?")}}<a href="{{ url('doctor/send_otp/'.$user->id) }}">{{__('Send Code Again')}}</a>
                </div>

            </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{ url('assets/img/login.png') }}">
            <div class="absolute-bottom-left index-2">
                <div class="text-light p-5 pb-2">
                    <div class="mb-5 pb-3">
                        <h1 class="mb-2 display-4 font-weight-bold">{{__('Welcome') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<script src="{{ url('assets_admin/js/jquery.min.js')}}"></script>
<script>
    $(function() {
        "use strict";
        $('.digit-group').find('input').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());
                if (e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));

                    if (prev.length) {
                        $(prev).select();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));

                    if (next.length) {
                        $(next).select();
                    } else {
                        if (parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });
    });
</script>

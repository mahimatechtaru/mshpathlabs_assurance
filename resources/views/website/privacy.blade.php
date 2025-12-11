@extends('layout.mainlayout',['activePage' => 'terms'])

@section('content')

<div class="pt-14">
    <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10 mb-5">{{__('Privacy Policy')}}</h1>

    <div class="xsm:mx-20 xxsm:mx-5">
        <div class="mb-10">
            {!! $privacy_policy !!}
        </div>
    </div>
</div>


@endsection

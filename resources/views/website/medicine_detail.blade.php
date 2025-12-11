@extends('layout.mainlayout',['activePage' => 'pharmacy'])

@section('content')
{{-- main container --}}
<div class="xl:w-3/4 mx-auto mt-20">

        @if(session('error'))
            @include('superAdmin.auth.errors',[
                'error' => session('error')])
        @endif

    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0">
        {{-- pharmacy Profile --}}
        <input type="hidden" name="pharmacy_id" value="{{ $medicine['pharmacy_id'] }}">
        <div class="flex justify-center w-full ">
            <div class="flex w-full border border-white-light justify-between">
                <div class="flex w-full 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-col xsm:flex-col xxsm:flex-col">
                    <div class="flex flex-col justify-center items-center bg-white-50 2xl:w-96 xl:w-96 xlg:w-96 xl:h-80 xlg:h-80 lg:h-80 lg:w-72 xmd:w-96 xmd:h-72 md:w-full md:h-72 md:mt-5 2xl:mt-0 xl:mt-0 xlg:mt-0 lg:mt-0 xmd:mt-0 sm:w-full sm:h-80 msm:w-96 msm:h-72  xsm:w-full xsm:h-72 xxsm:w-full xxsm:h-72">
                        <img class="2xl:w-60 2xl:h-72 xlg:h-60 xlg:w-52 xl:h-60 xl:w-52 lg:h-60 lg:w-60 xmd:w-60 xmd:h-60 md:h-72 md:w-72 sm:h-72 sm:w-72 msm:w-72 msm:h-72 xsm:h-60 xsm:w-60 msm:py-5 xxsm:h-60 xxsm:w-60 " src="{{ url($medicine->fullImage) }}" alt="" />
                    </div>
                    <div class="w-full flex flex-col justify-center border-l border-white-light xmd:pb-5 md:pt-5 sm:pt-5">
                        <div class="2xl:px-10 xl:px-10 xlg:px-10 lg:px-10 xmd:px-10 md:px-10 xxsm:px-5">
                            <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left">
                            <p class="text-xl font-normal leading-6 font-fira-sans text-black">{{$medicine['name']}}</p>
                            <div>{!! $medicine['description'] !!}</div>
                        </div>
                        <div class="flex justify-between items-center xxsm:flex-col xmd:flex-row 2xl:flex-row 2xl:px-10 xl:px-10 xl:pt-2 xlg:px-10 lg:px-10 xmd:px-10 md:px-10 xxsm:px-5  md:mt-5 sm:mt-5 msm:mt-6 xsm:mt-6 xxsm:mt-6 mb-10">
                            <div class="">
                                <h1 class="font-fira-sans text-sm font-normal leading-5 text-gray">{{__('Quantity')}}</h1>
                                <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                    <button id="minus{{ $medicine['id'] }}" onclick="addCart({{$medicine['id']}},`minus`)" data-action="decrement" class="border-l border-t border-white-light border-b text-black-600 hover:text-black-700 h-8 w-6 cursor-pointer">
                                        <span class="m-auto text-2xl font-thin">−</span>
                                    </button>
                                    <input type="number" id="txtCart{{ $medicine['id'] }}" readonly class="border-t border-b border-white-light outline-none focus:outline-none text-center w-10 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-primary h-8 p-1" name="custom-input-number" value="0">
                                    <button onclick="addCart({{$medicine['id']}},`plus`)" data-action="increment" class="border-r border-t border-b border-white-light text-black-600 hover:text-black-700 h-8 w-6 cursor-pointer">
                                        <span class="m-auto text-2xl font-thin">+</span>
                                    </button>
                                </div>
                            </div>
                            <div class="pt-2 2xl:mr-80 xl:mr-40 mb-5">
                                <h1 class="text-primary text-xl font-fira-sans font-normal leading-5">{{ $currency }}{{ $medicine['price_pr_strip'] }}</h1>
                                <h1 class="text-gray text-sm font-fira-sans font-normal leading-5 pt-2">{{ $medicine->total_stock }}{{ __(' Strip available') }}</h1>
                            </div>
                            <div>
                                <a href="{{ url('view-cart') }}" class="bg-primary text-white px-8 py-3"><i class="fa-solid fa-bag-shopping"></i> {{__('View Cart')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- first div --}}
        <div class="flex border-b border-white-light mb-20">
            {{-- first part --}}
            <div class="border-r border-white-light pb-10 p-3">
                <h1 class="text-xl font-normal leading-6 font-fira-sans text-black pb-4 mt-4">{{__('Product Details')}}</h1>
                <h1 class="text-xl font-medium leading-6 font-fira-sans text-black pt-6 pb-4">{{__('How It Works')}}</h1>
                <div>
                    {!! $medicine['works'] !!}
                </div>
                <div class="mt-4 bg-white-50 rounded-3">
                    @if (isset($medicine->meta_info))
                    @foreach (json_decode($medicine->meta_info) as $item)
                    <div class="mt-4">
                        <h6 class="text-xl font-medium leading-6 font-fira-sans text-black pb-4">{{ $item->title }}</h6>
                        <div class="leading-4 font-fira-sans font-normal text-sm text-gray">{!! clean($item->desc) !!}</div>
                    </div>
                    @endforeach
                    @else
                    <h4 class="text-xl font-medium leading-6 font-fira-sans text-black pb-4">{{__('No Meta information available for this product')}}</h4>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/medicine_list.js') }}"></script>
@endsection

@extends('layout.mainlayout',['activePage' => 'offers'])

@section('css')
<style>
    .mainDiv .hoverDoc {
        display: none;
    }

    .mainDiv:hover .mainDiv1 {
        display: none;
    }

    .mainDiv:hover .hoverDoc,
    .mainDiv1 {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="pt-14 pb-10  border-b border-gray-light mb-10">
    <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10">{{__('Our Offers ')}}</h1>
    <div class="p-5">
        <p class="font-fira-sans font-normal text-lg text-center leading-5 text-gray">{{__('Coupons and Discount')}}
        </p>
    </div>
</div>
<div class="xl:w-3/4 mx-auto">
    <div class="pb-20 flex 2xl:flex-col xl:flex-col xlg:flex-col lg:flex-col xmd:flex-col msm:flex-col xsm:flex-col xxsm:flex-col xxsm:mx-5 xl:mx-0 2xl:mx-0">
        @if(count($offers) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xmd:grid-cols-2 xlg:grid-cols-4">
            @foreach ($offers as $offer)
            <div class="bg-white-50 border border-white-light mainDiv">
                <div class="mainDiv1 flex flex-col justify-center p-5 1xl:h-[350px] xxmd:h-[300px] xmd:h-[300px] msm:h-[300px] xsm:h-[300px] xxsm:h-[300px]">
                    <img class="2xl:w-full 2xl:h-[209px] xlg:h-40 xlg:w-full xl:h-40 xl:w-full lg:h-40 lg:w-full md:h-32 md:w-full sm:h-32 sm:w-full xsm:h-32 xsm:w-full msm:h-32 msm:w-full xxsm:h-32 xxsm:w-full sm:w-full" src="{{ $offer->full_image }}" alt="" />
                    <h5 class="font-fira-sans font-normal text-xl leading-6 text-black text-left md:text-md pt-5">{{ $offer->name }}</h5>
                    <div class="flex flex-row justify-between 2xl:mt-8 xl:mt-8 xlg:mt-2 lg:mt-2 xmd:mt-2 md:mt-4 sm:mt-4 msm:-4 xsm:mt-4 xxsm:mt-4">
                        <p class="font-medium leading-4 text-sm text-primary  font-fira-sans md:text-md">
                            {{ $offer->offer_code }}
                        </p>
                        <p class="font-normal leading-4 text-sm text-gray md:text-md">{{ Carbon\Carbon::parse($offer->created_at)->format('d M,Y') }}</p>
                    </div>
                </div>
                <div class="hoverDoc shadow-2xl overflow-hidden">
                    <div class="w-full 1xl:h-[350px] xxmd:h-[300px] xmd:h-[300px] msm:h-[300px] xsm:h-[300px] xxsm:h-[300px] p-5">
                        <div class="flex flex-col items-center">
                            <div>
                                <img class="2xl:w-16 2xl:h-16 xlg:h-16 xlg:w-16 xl:h-16 xl:w-16 lg:h-16 lg:w-16 xxmd:w-16 xxmd:h-16 md:h-10 md:w-10 sm:h-10 sm:w-10 xsm:h-10 xsm:w-10 msm:h-14
                                        msm:w-14 xxsm:h-14 xxsm:w-14  border border-primary rounded-full p-0.5 mx-5 object-cover bg-cover" src="{{ $offer->full_image }}" alt="" />
                                <div class="flex flex-col justify-start xl:block xlg:hidden lg:hidden xxmd:hidden">
                                    <h5 class="font-fira-sans font-normal text-xl leading-6 text-black-dark">
                                        @if ($offer->is_flat == 1)
                                        <span class="font-normal leading-4 text-sm text-black text-center">{{ $currency }}{{ $offer->flatDiscount }}</span>
                                        <span class="font-normal leading-4 text-sm text-black text-center">{{__('Flat Discount')}}</span>
                                        @else
                                        @if ($offer->discount_type == 'amount')
                                        <span class="font-normal leading-4 text-sm text-black text-center">{{ $currency }}{{ $offer->discount }}</span>
                                        @endif
                                        @if ($offer->discount_type == 'percentage')
                                        <span>{{ $offer->discount }}%</span>
                                        @endif
                                        <span class="font-normal leading-4 text-sm text-black text-center">{{__('OFF')}}</span>
                                        @endif
                                        @php
                                        $startDate = explode(' - ',$offer->start_end_date);
                                        @endphp
                                    </h5>
                                    <p class="font-normal leading-4 text-sm text-gray text-center pt-3">{{__('Expires:')}}<span class="text-black">
                                            {{ Carbon\Carbon::parse($startDate[1])->format('d M,Y') }}</span></p>
                                </div>
                                <p class="font-medium leading-4 mt-2 text-sm text-primary font-fira-sans md:text-md text-center">{{ $offer->offer_code }}</p>
                            </div>
                            <div class="mt-5">
                                <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left">{{$offer->desc}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex justify-center mt-32 font-fira-sans font-normal text-base text-gray">
            {{__('No Data Available')}}
        </div>
        @endif
    </div>
</div>

@endsection

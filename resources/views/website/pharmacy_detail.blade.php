@extends('layout.mainlayout',['activePage' => 'pharmacy'])

@section('content')
<div class="xl:w-3/4 mx-auto">
    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0 flex justify-center 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-col xsm:flex-col xxsm:flex-col msm:pt-5 mt-10 ">
        <div class="flex bg-white w-full 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row  md:flex-col sm:flex-col msm:flex-col xsm:flex-col xxsm:flex-col border border-white-light justify-between">
            <div class="flex 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-row xsm:flex-col xxsm:flex-col">
                <div class="bg-white 2xl:w-60 xl:w-60 xlg:w-60 xl:h-80 xlg:h-80 lg:h-80 lg:w-60 xmd:w-52 xmd:h-72 md:w-full md:h-72 sm:w-full sm:h-72 msm:w-96 msm:h-72 xsm:w-full xsm:h-60 xxsm:w-full xxsm:h-60">
                    <div class="flex flex-col justify-center items-center xmd:mt-5 md:mt-10 lg:mt-10 sm:mt-14 msm:mt-10 xsm:mt-11 xxsm:mt-11">
                        <img class="2xl:w-28  2xl:h-28 xlg:h-20 xlg:w-20 xl:h-20 xl:w-20 lg:h-20 lg:w-20 md:h-20 md:w-20 sm:h-20 sm:w-20 msm:w-20 msm:h-20 xsm:h-20 xsm:w-20 xxsm:h-20 xxsm:w-20  rounded-full" src="{{ $pharmacy->full_image }}" alt="" />
                        <h5 class="font-fira-sans font-normal text-xl leading-6 text-black-dark text-center md:text-md pt-5">{{ $pharmacy->name }}</h5>
                        <p class="font-normal leading-4 text-sm text-gray text-center md:text-md pt-3"><i class="fa-solid fa-door-open text-primary"></i> {{__('Opens At')}} {{ $pharmacy['openTime'] }}</p>
                    </div>
                </div>
                <div class="bg-white 2xl:w-96 xl:w-80 xlg:w-72 xl:h-80 xlg:h-80 lg:h-80 lg:w-64 xmd:w-60 xmd:h-72 md:w-full md:h-72 sm:w-full sm:h-72 msm:w-96 msm:h-72 xsm:w-full xsm:h-72 xxsm:w-full xxsm:h-72">
                    <div class="flex flex-col justify-center xmd:mt-5 md:mt-5 lg:mt-10 sm:mt-0 msm:mt-5 xsm:mt-5 xxsm:mt-1  border-l border-white-light">
                        <div class="2xl:px-10 xl:px-10 xlg:px-10 lg:px-10 xmd:px-10 md:px-10 xxsm:px-5">
                            <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-5">
                            @if(auth()->user())
                            <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left"><span><i class="fa-solid fa-phone"></i></span> {{ $pharmacy['phone'] }}</p>
                            <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left py-4"><span class="text-bold">{{__('@')}}</span> {{ $pharmacy['email'] }}</p>
                            @else
                            <a href="/patient-login" title={{__('Login to view') }}><p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left"><span><i class="fa-solid fa-phone"></i></span> {{__('Login to view') }}</p></a>
                            <a href="/patient-login" title={{__('Login to view') }}><p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left py-4"><span class="text-bold">{{__('@')}}</span> {{__('Login to view') }}</p></a>
                            @endif
                            <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-2"><span><i class="fa-solid fa-location-dot"></i></span> {{ $pharmacy['address'] }}</p>
                        </div>
                        <div class="2xl:pt-6 2xl:px-10 xl:px-10 xl:pt-4 xlg:px-10 lg:px-10 xmd:px-10 md:px-10 xxsm:px-5 xlg:mt-6 lg:mt-6 xmd:mt-5 md:mt-5 sm:mt-5 msm:mt-6 xsm:mt-6 xxsm:mt-6">
                            <a href="{{ url('pharmacy-product/'.$pharmacy['id'].'/'.Str::slug($pharmacy['name'])) }}" class="lg:px-1 lg:w-44 xsm:w-36 md:px-2 text-sm xl:py-2 xlg:py-2 xl:px-4 xlg:px-4 lg:py-2 xmd:py-1 md:py-2 sm:py-2 sm:px-2 msm:py-2 msm:px-3 xsm:px-3 xsm:py-2 xxsm:py-2 xxsm:px-3 text-white bg-primary text-center">{{__('Browse Products')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white 2xl:w-96 xl:w-80 xlg:w-72 xl:h-80 xlg:h-80 lg:h-80 lg:w-64 xmd:w-52 xmd:h-72 md:w-full md:h-0 sm:w-full sm:h-0 msm:w-96 msm:h-20 xsm:w-full xsm:h-20 xxsm:w-full xxsm:h-20">
                <div class="flex flex-col items-end 2xl:mt-14 xl:mt-10 xlg:mt-10  lg:mt-10 xmd:mt-8 md:mt-0 sm:mt-0 msm:mt-0 xsm:mt-0 xxsm:mt-0">
                    <div class="2xl:mx-11 xl:mx-11 xlg:mx-11 lg:mx-11 xmd:mx-11 md:mx-10 sm:mx-10 msm:mx-2 xsm:mx-5 xxsm:mx-5 2xl:mt-40 xl:mt-40 xlg:mt-40 lg:mt-40 xmd:mt-40 md:mt-0 sm:mt-0 msm:mt-0 xsm:mt-0 xxsm:mt-0">
                        @if(auth()->user())
                        <a href="tel:{{ $pharmacy['phone'] }}" class="text-primary"><i class="fa-solid fa-phone border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        <a href="mailto:{{ $pharmacy['email'] }}" class="text-primary"><i class="fa-solid fa-envelope border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        @else
                        <a href="/patient-login" class="text-primary" title={{__('Login to view') }}><i class="fa-solid fa-phone border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        <a href="/patient-login" class="text-primary" title={{__('Login to view') }}><i class="fa-solid fa-envelope border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- main container --}}
    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0 mb-14">
        {{-- first div --}}
        <div class="flex 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:row sm:flex-col sms:flex-col xsm:flex-col
       xxsm:flex-col">
            {{-- first part --}}
            <div class="2xl:w-3/4 xxsm:w-full border-r border-white-light">
                <div class="border-b border-white-light  pb-6 pt-6">
                    <h1 class="text-xl font-normal leading-6 font-fira-sans text-black pb-4">{{__('Overview')}}</h1>
                    {!! nl2br( $pharmacy['description']) !!}
                </div>

            </div>
            {{-- second part --}}
            <div class="border-b border-white-light">
                <div class="ml-3 2xl:w-96 xl:w-96 xlg:w-96 lg:w-96 xmd:w-96 md:w-96 sm:w-96 xsm:w-80 xxsm:w-40 xxsm:pl-0 pb-3">
                    <h1 class="text-xl font-normal leading-6 font-fira-sans text-black pt-8">{{__('Business Hours')}} </h1>
                    <div class="flex 2xl:flex-row xl:flex-row xlg:flex-col lg:flex-col xsm:flex-row xxsm:flex-col justify-between mt-5 pt-3 pb-3 px-3 2xl:px-3 bg-light-green">
                        <div class="">
                            <h1 class="text-base font-fira-sans leading-5 font-normal text-black"><span class="text-primary">{{__('Today • ')}}</span>{{ $today_date[0] }}</h1>
                            <p class="font-fira-sans leading-4 text-sm font-normal text-gray pt-2">
                                @foreach (json_decode($today_date[1]) as $date)
                                <span class="flex flex-col pt-1">{{ $date->start_time }} - {{ $date->end_time }}</span>
                                @endforeach
                            </p>
                        </div>
                        <div class="xlg:pt-2">
                            <button type="button" class="text-white bg-primary text-center py-2 px-2 text-xs font-normal leading-3 font-fira-sans rounded-full">{{__('Open Now')}}</button>
                        </div>
                    </div>

                    @foreach ($pharmacyWorkingHours as $pharmacyWorkingHour)
                        @php
                            $workingHours = json_decode($pharmacyWorkingHour->period_list, true);
                            $dayDisplayed = false;
                        @endphp

                        @foreach ($workingHours as $time)
                            @if (!$dayDisplayed)
                                <div class="flex justify-between pt-5">
                                    <div>
                                        <h1 class="font-fira-sans leading-4 text-sm font-medium text-black">{{ $pharmacyWorkingHour->day_index }}</h1>
                                    </div>
                                    <div>
                                        <p class="font-fira-sans leading-4 text-sm font-normal {{ $pharmacyWorkingHour->status ? 'text-gray' : 'text-red' }} pt-2">
                                            {{ $pharmacyWorkingHour->status ? $time['start_time'].' - '.$time['end_time'] : __('Closed') }}
                                        </p>
                                    </div>
                                </div>
                                @php
                                    $dayDisplayed = true;
                                @endphp
                            @else
                                <div class="flex justify-between px-3 pt-2">
                                    <div></div>
                                    <div>
                                        <p class="font-fira-sans leading-4 text-sm font-normal {{ $pharmacyWorkingHour->status ? 'text-gray' : 'text-red' }} pt-2">
                                            {{ $pharmacyWorkingHour->status ? $time['start_time'].' - '.$time['end_time'] : __('Closed') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

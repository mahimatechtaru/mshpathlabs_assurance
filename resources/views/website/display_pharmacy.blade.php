@if (count($pharmacies) > 0)
@if (isset($pharmacies['data']))
@php
$data = $pharmacies['data'];
@endphp
@else
@php
$data = $pharmacies;
@endphp
@endif

@foreach ($data as $index => $pharmacy)
<div class="mainDiv xxsm:mx-0 border border-white-light">
    <div class="mainDiv1 xlg:py-8 lg:py-7 xxsm:px-2 xxsm:py-10 1xl:h-[350px] xxmd:h-[300px] xmd:h-[300px] msm:h-[300px]">
        <img class="1xl:mt-8 msm:mt-0 xsm:mt-0 xxsm:mt-0 border-2 border-primary rounded-full p-0.5 m-auto mt-12 object-cover w-36 h-36" src="{{ url($pharmacy['fullImage']) }}" alt="" style="display: flex !important;" />
        <h5 class="font-fira-sans font-normal text-xl leading-6 text-black-dark text-center md:text-md pt-5">
            {{ $pharmacy['name'] }}
        </h5>
        @if(auth()->user())
        <p class="font-normal leading-4 text-sm text-center font-fira-sans md:text-md py-2 text-gray">{{ __('@') }}
            <span>{{ $pharmacy['email'] }}</span>
        </p>
        @else
        <p class="font-normal leading-4 text-sm text-center font-fira-sans md:text-md py-2 text-gray">
            <span> {{ __('Login to view') }}&nbsp;{{ __('email') }}</span>
        </p>
        @endif
        <div class="font-normal leading-4 text-sm text-primary text-center md:text-md flex justify-center">
            <svg width="13" height="18" viewBox="0 0 13 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.65449 17.1566C4.75413 17.2346 4.87026 17.2888 4.99402 17.315C5.11779 17.3413 5.24593 17.339 5.36866 17.3082L12.0353 15.6416C12.2158 15.5967 12.376 15.4927 12.4905 15.3462C12.6049 15.1997 12.6671 15.0191 12.667 14.8332V3.16656C12.6669 2.98067 12.6047 2.80014 12.4903 2.65367C12.3758 2.5072 12.2157 2.40321 12.0353 2.35822L5.36866 0.691558C5.24588 0.661433 5.11786 0.659551 4.99425 0.686056C4.87064 0.712561 4.75465 0.766761 4.65501 0.844576C4.55538 0.922392 4.47469 1.0218 4.41903 1.1353C4.36337 1.24881 4.33418 1.37347 4.33366 1.49989V2.33322H1.00033C0.779312 2.33322 0.56735 2.42102 0.41107 2.5773C0.25479 2.73358 0.166992 2.94554 0.166992 3.16656V14.8332C0.166992 15.0542 0.25479 15.2662 0.41107 15.4225C0.56735 15.5788 0.779312 15.6666 1.00033 15.6666H4.33366V16.4999C4.33366 16.7566 4.45199 16.9991 4.65449 17.1566ZM6.00033 2.56739L11.0003 3.81739V14.1824L6.00033 15.4324V2.56739ZM1.83366 13.9999V3.99989H4.33366V13.9999H1.83366Z">
                </path>
                <path d="M7.86801 9.96602C8.23967 9.87268 8.49967 9.53935 8.49967 9.15685V8.84268C8.49956 8.62167 8.41166 8.40975 8.2553 8.25355C8.09894 8.09735 7.88694 8.00966 7.66592 8.00977C7.44491 8.00988 7.23299 8.09778 7.07679 8.25414C6.92059 8.4105 6.8329 8.6225 6.83301 8.84352V9.15768C6.83304 9.28426 6.86191 9.40917 6.91743 9.52293C6.97295 9.63669 7.05365 9.73631 7.15341 9.81422C7.25317 9.89213 7.36937 9.9463 7.49319 9.9726C7.61701 9.9989 7.74519 9.99665 7.86801 9.96602Z">
                </path>
            </svg>
            <p class="ml-2">
                {{ __(' Opens At') }} {{ $pharmacy['openTime'] }}
            </p>

        </div>

    </div>

    <!-- <div class="hoverDoc shadow-2xl overflow-hidden">
        <div class="w-full 1xl:h-[350px] xxmd:h-[300px] xmd:h-[300px] msm:h-[300px] xsm:h-[300px] xxsm:h-[300px] p-5">
            <div class="flex flex-col items-center">
                <div class="flex">
                    <img class="2xl:w-16 2xl:h-16 xlg:h-16 xlg:w-16 xl:h-16 xl:w-16 lg:h-16 lg:w-16 xxmd:w-16 xxmd:h-16 md:h-16 md:w-16 sm:h-10 sm:w-10 xsm:h-10 xsm:w-10 msm:h-14
                            msm:w-14 xxsm:h-14 xxsm:w-14  border border-primary rounded-full p-0.5 mx-5 object-cover bg-cover" src="{{ url($pharmacy['fullImage']) }}" alt="" />
                    <div class="flex flex-col justify-start">
                        <h5 class="font-fira-sans font-normal text-xl xl:text-sm leading-6 text-black-dark">
                            {{ $pharmacy['name'] }}
                        </h5>
                        <p class="font-normal leading-4 text-sm text-gray text-center xl:text-sm md:text-md pt-3">
                        <div class="font-normal leading-4 text-sm text-primary text-center md:text-md flex justify-center">
                            <svg width="13" height="18" viewBox="0 0 13 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.65449 17.1566C4.75413 17.2346 4.87026 17.2888 4.99402 17.315C5.11779 17.3413 5.24593 17.339 5.36866 17.3082L12.0353 15.6416C12.2158 15.5967 12.376 15.4927 12.4905 15.3462C12.6049 15.1997 12.6671 15.0191 12.667 14.8332V3.16656C12.6669 2.98067 12.6047 2.80014 12.4903 2.65367C12.3758 2.5072 12.2157 2.40321 12.0353 2.35822L5.36866 0.691558C5.24588 0.661433 5.11786 0.659551 4.99425 0.686056C4.87064 0.712561 4.75465 0.766761 4.65501 0.844576C4.55538 0.922392 4.47469 1.0218 4.41903 1.1353C4.36337 1.24881 4.33418 1.37347 4.33366 1.49989V2.33322H1.00033C0.779312 2.33322 0.56735 2.42102 0.41107 2.5773C0.25479 2.73358 0.166992 2.94554 0.166992 3.16656V14.8332C0.166992 15.0542 0.25479 15.2662 0.41107 15.4225C0.56735 15.5788 0.779312 15.6666 1.00033 15.6666H4.33366V16.4999C4.33366 16.7566 4.45199 16.9991 4.65449 17.1566ZM6.00033 2.56739L11.0003 3.81739V14.1824L6.00033 15.4324V2.56739ZM1.83366 13.9999V3.99989H4.33366V13.9999H1.83366Z">
                                </path>
                                <path d="M7.86801 9.96602C8.23967 9.87268 8.49967 9.53935 8.49967 9.15685V8.84268C8.49956 8.62167 8.41166 8.40975 8.2553 8.25355C8.09894 8.09735 7.88694 8.00966 7.66592 8.00977C7.44491 8.00988 7.23299 8.09778 7.07679 8.25414C6.92059 8.4105 6.8329 8.6225 6.83301 8.84352V9.15768C6.83304 9.28426 6.86191 9.40917 6.91743 9.52293C6.97295 9.63669 7.05365 9.73631 7.15341 9.81422C7.25317 9.89213 7.36937 9.9463 7.49319 9.9726C7.61701 9.9989 7.74519 9.99665 7.86801 9.96602Z">
                                </path>
                            </svg>&nbsp;
                            <p class="">
                                {{ __(' Opens At ') }}{{ $pharmacy['openTime'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col 1xl:mt-10 xl:mt-3 xlg:mt-2 lg:mt-5 xxmd:mt-5 md:mt-5 sm:mt-5 msm:mt-2 xsm:mt-5 xxsm:mt-2">
                    <div class="h-44 xl:h-40 xlg:h-20 lg:h-32 xxmd:h-32 md:h-32 sm:h-36 msm:h-36 xsm:h-36 xxsm:h-36">
                        <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left"><span><i class="fa-solid fa-phone"></i></span> {{ $pharmacy['phone'] }}</p>
                        <p class="font-fira-sans font-normal msm:text-sm xxsm:text-xs leading-4 text-gray text-left py-2">
                            <span class="text-bold ">{{ __('@') }}</span> {{ $pharmacy['email'] }}
                        </p>
                        <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-2 xlg:hidden">
                            <span><i class="fa-solid fa-location-dot"></i></span> {{ $pharmacy['address'] }}
                        </p>

                    </div>
                    <div class="flex xl:flex-row xlg:flex-col lg:flex-row">
                        <a href="{{ url('pharmacy-product/'.$pharmacy['id'].'/'.Str::slug($pharmacy['name'])) }}" class="font-fira-sans text-white bg-primary hover:bg-primary text-center py-2.5 px-5">{{__('Browse Products')}}</a>
                        <a href="{{ url('pharmacy-details/'.$pharmacy['id'].'/'.Str::slug($pharmacy['name'])) }}" class="font-fira-sans text-primary text-sm font-normal leading-4 underline mx-5 py-2">{{__('View Profile')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <div class="hoverDoc bg-white shadow-2xl p-5 relative hover:z-50 xxsm:w-full xxsm:h-[500px] md:h-[300px] xlg:w-[280px] lg:h-[300px] lg:overflow-y-auto xl:w-[250px] 1xl:h-[350px] 1xl:overflow-y-auto 1xl:w-[500px] 1xl:h-[350px] 2xl:w-[560px]">

        <div class="flex items-center xxsm:flex-col md:flex-row lg:flex-col 1xl:flex-row 1xl:mt-10">
            <div class="1xl:w-[40%] xlg:w-full xxsm:mb-5 xlg:mb-0 md:w-[40%] lg:w-full ">
                <img class="border-2 border-primary rounded-full p-0.5 object-cover w-36 h-36 mx-auto" src="{{ url($pharmacy['fullImage']) }}" alt="" />
                <h5 class="font-fira-sans font-normal text-xl leading-6 text-black-dark pt-5 text-center mb-5">{{ $pharmacy['name'] }}</h5>
                <div class="font-normal leading-4 text-sm text-primary text-center md:text-md flex justify-center">
                    <svg width="13" height="18" viewBox="0 0 13 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.65449 17.1566C4.75413 17.2346 4.87026 17.2888 4.99402 17.315C5.11779 17.3413 5.24593 17.339 5.36866 17.3082L12.0353 15.6416C12.2158 15.5967 12.376 15.4927 12.4905 15.3462C12.6049 15.1997 12.6671 15.0191 12.667 14.8332V3.16656C12.6669 2.98067 12.6047 2.80014 12.4903 2.65367C12.3758 2.5072 12.2157 2.40321 12.0353 2.35822L5.36866 0.691558C5.24588 0.661433 5.11786 0.659551 4.99425 0.686056C4.87064 0.712561 4.75465 0.766761 4.65501 0.844576C4.55538 0.922392 4.47469 1.0218 4.41903 1.1353C4.36337 1.24881 4.33418 1.37347 4.33366 1.49989V2.33322H1.00033C0.779312 2.33322 0.56735 2.42102 0.41107 2.5773C0.25479 2.73358 0.166992 2.94554 0.166992 3.16656V14.8332C0.166992 15.0542 0.25479 15.2662 0.41107 15.4225C0.56735 15.5788 0.779312 15.6666 1.00033 15.6666H4.33366V16.4999C4.33366 16.7566 4.45199 16.9991 4.65449 17.1566ZM6.00033 2.56739L11.0003 3.81739V14.1824L6.00033 15.4324V2.56739ZM1.83366 13.9999V3.99989H4.33366V13.9999H1.83366Z">
                        </path>
                        <path d="M7.86801 9.96602C8.23967 9.87268 8.49967 9.53935 8.49967 9.15685V8.84268C8.49956 8.62167 8.41166 8.40975 8.2553 8.25355C8.09894 8.09735 7.88694 8.00966 7.66592 8.00977C7.44491 8.00988 7.23299 8.09778 7.07679 8.25414C6.92059 8.4105 6.8329 8.6225 6.83301 8.84352V9.15768C6.83304 9.28426 6.86191 9.40917 6.91743 9.52293C6.97295 9.63669 7.05365 9.73631 7.15341 9.81422C7.25317 9.89213 7.36937 9.9463 7.49319 9.9726C7.61701 9.9989 7.74519 9.99665 7.86801 9.96602Z">
                        </path>
                    </svg>
                    <p class="ml-2">
                        {{ __(' Opens At') }} {{ $pharmacy['openTime'] }}
                    </p>
                </div>
            </div>
            <div class="1xl:w-[60%] xlg:w-full md:w-[60%] lg:w-full xxsm:pl-0 xmd:pl-10 xxsm:ml-0 xlg:pl-0 lg:ml-0 lg:pl-0 1xl:pl-5 md:pl-5 md:border-l-2 md:border-white-light xxsm:border-l-0 lg:border-l-0 xl:border-l-0 xl:pl-0 1xl:border-l-2 h-[200px]">
                <div>
                    <div class="md:mb-20 xxsm:mb-5 xsm:mb-6 xlg:mb-5 lg:mb-10 1xl:mb-10 2xl:mb-10 xxsm:mt-0 xlg:mt-4">
                        @if(auth()->user())
                        <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left"><span><i
                                    class="fa-solid fa-phone"></i></span> {{ $pharmacy['phone'] }}</p>
                        <p
                            class="font-fira-sans font-normal msm:text-sm xxsm:text-xs leading-4 text-gray text-left py-2">
                            <span class="text-bold ">{{ __('@') }}</span> {{ $pharmacy['email'] }}
                        </p>
                        @else
                        <a href="/patient-login" title="{{ __('Login to view') }}">
                            <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left"><span><i
                                        class="fa-solid fa-phone"></i></span> {{ __('Login to view') }}&nbsp;{{ __('phone') }}
                            </p>
                        </a>
                        <a href="/patient-login" title="{{ __('Login to view') }}">
                            <p
                                class="font-fira-sans font-normal msm:text-sm xxsm:text-xs leading-4 text-gray text-left py-2">
                                <span class="text-bold ">{{ __('@') }}</span> {{ __('Login to view') }}&nbsp;{{ __('email') }}
                            </p>
                        </a>
                        @endif
                        <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-2">
                            <span><i class="fa-solid fa-location-dot"></i></span> {{ $pharmacy['address'] }}
                        </p>
                    </div>
                    <div class="flex xl:flex-col xlg:flex-row lg:flex-row xsm:flex-row xxsm:flex-col items-center 1xl:flex-row">
                        <a href="{{ url('pharmacy-product/'.$pharmacy['id'].'/'.Str::slug($pharmacy['name'])) }}" class="font-fira-sans text-white bg-primary hover:bg-primary text-sm text-center py-2.5 px-5">{{__('Browse Products')}}</a>
                        <a href="{{ url('pharmacy-details/'.$pharmacy['id'].'/'.Str::slug($pharmacy['name'])) }}" class="font-fira-sans text-primary text-sm font-normal leading-4 underline py-2 ml-3">{{__('View Profile')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

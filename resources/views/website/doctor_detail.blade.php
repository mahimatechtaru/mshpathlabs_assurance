@extends('layout.mainlayout',['activePage' => 'doctors', 'title' => $doctor->name])

@if (App\Models\Setting::first()->map_key)
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&libraries=places&v=weekly" async></script>
@endif

@section('content')

{{-- Doctor Profile --}}
<div class="xxsm:mx-5 xl:mx-0 2xl:mx-0">
    <div class="xl:w-3/4 mx-auto flex justify-center 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-col xsm:flex-col xxsm:flex-col msm:pt-5 mt-10">
        <div class="flex w-full 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row  md:flex-col sm:flex-col msm:flex-col xsm:flex-col xxsm:flex-col border border-white-light justify-between">
            <div class="flex 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-row xsm:flex-col xxsm:flex-col">
                <div class="bg-white-50 2xl:w-60 xl:w-60 xlg:w-60 xl:h-80 xlg:h-80 lg:h-80 lg:w-60 xmd:w-52 xmd:h-72 md:w-full md:h-72 sm:w-full sm:h-72 msm:w-96 msm:h-72 xsm:w-full xsm:h-60 xxsm:w-full xxsm:h-60">
                    <div class="flex flex-col justify-center items-center xmd:mt-5 md:mt-10 lg:mt-10 sm:mt-14 msm:mt-10 xsm:mt-11 xxsm:mt-11">
                        <img class="2xl:w-28  2xl:h-28 xlg:h-20 xlg:w-20 xl:h-20 xl:w-20 lg:h-20 lg:w-20 md:h-20 md:w-20 sm:h-20 sm:w-20 msm:w-20 msm:h-20 xsm:h-20 xsm:w-20 xxsm:h-20 xxsm:w-20 border border-primary rounded-full" src="{{ $doctor->full_image }}" alt="" />
                        <h5 class="font-fira-sans font-normal text-xl leading-6 text-black-dark text-center md:text-md pt-5">
                            {{ $doctor->name }}
                        </h5>
                        <p class="font-normal leading-4 text-sm text-primary text-center font-fira-sans md:text-md py-2">{{
                        $doctor->category['name'] }}</p>
                        <p class="font-normal leading-4 text-sm text-gray text-center md:text-md"><i class="fa-solid fa-star text-yellow"></i> {{ $doctor['rate'] }} ({{ $doctor['review']
                        }}{{__(' reviews') }})</p>
                    </div>
                </div>
                <div class="bg-white-50 2xl:w-96 xl:w-80 xlg:w-72 xl:h-80 xlg:h-80 lg:h-80 lg:w-64 xmd:w-60 xmd:h-72 md:w-full md:h-72 sm:w-full sm:h-72 msm:w-96 msm:h-72 xsm:w-full xsm:h-72 xxsm:w-full xxsm:h-72">
                    <div class="flex flex-col justify-center xmd:mt-5 md:mt-5 lg:mt-10 sm:mt-11 msm:mt-5 xsm:mt-5 xxsm:mt-1 border-l border-white-light overflow-y-scroll h-64">
                        <div class="2xl:px-10 xl:px-10 xlg:px-10 lg:px-10 xmd:px-10 md:px-10 xxsm:px-5">
                            @if (isset($doctor->expertise) && isset($doctor->category))
                            <div class="flex">
                                <p class=" font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-5 pr-2 border-r">
                                    {{$doctor->expertise['name']}}
                                </p>
                                <img src="{{ $doctor->category['fullImage'] }}" class="ml-2 pt-5 pr-2 h-10 w-8" alt="">
                                <p class="ml-2 mr-2 font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-5">
                                    {{$doctor->category['name']}}
                                </p>
                            </div>
                            @endif
                            @foreach ($doctor->hospital as $hospital)
                            <p class="font-fira-sans font-medium text-base leading-5 text-black-dark text-left pt-3">
                                {{$hospital->name}}
                            </p>
                            <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-2"><span><i class="fa-solid fa-location-dot mr-1"></i></span> {{ $hospital->address }}</p>
                            <h1 class="font-fira-sans font-normal text-sm text-gray leading-4 pt-4"><span class="text-primary"><i class="fa-regular fa-comment mr-1"></i></span>{{
                            count($reviews) }}{{__(' Feedback') }}</h1>
                            @endforeach
                        </div>
                        <div class="2xl:px-10 xl:px-10 xlg:px-10 lg:px-10 xmd:px-10 md:px-10 xxsm:px-5 lg:mt-10 md:mt-5 sm:mt-5 msm:mt-6 xsm:mt-6 xxsm:mt-6">
                            <a href="{{ url('booking/'.$doctor->id.'/'.Str::slug($doctor->name)) }}" class="lg:px-1 lg:w-44 xsm:w-36 md:px-2 text-sm xl:py-2 xlg:py-2 xl:px-4 xlg:px-4 lg:py-2 xmd:py-1 md:py-2 sm:py-2 sm:px-2 msm:py-2 msm:px-3 xsm:px-3 xsm:py-2 xxsm:py-2 xxsm:px-3 text-white bg-primary hover:bg-primary text-center">{{__('Make
                            Appointment')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white-50 2xl:w-96 xl:w-80 xlg:w-72 xl:h-80 xlg:h-80 lg:h-80 lg:w-64 xmd:w-52 xmd:h-72 md:w-full md:h-72 sm:w-full sm:h-72 msm:w-96 msm:h-72 xsm:w-full xsm:h-72 xxsm:w-full xxsm:h-40">
                <div class="flex flex-col items-end 2xl:mt-10 xl:mt-10 xlg:mt-10  lg:mt-10 xmd:mt-8 md:mt-8 sm:mt-11 msm:mt-8 xsm:mt-0 xxsm:mt-0">
                    <h1 class="font-fira-sans font-semibold text-xl text-primary leading-7 pt-5 xmd:pt-2 sm:pt-1 2xl:mx-11 xl:mx11 xl:mx-11 lg:mx-11 xmd:mx-11 md:mx-11 sm:mx-10 msm:mx-2 xsm:mx-5 xxsm:mx-5">
                        {{ $currency }}{{ $doctor->appointment_fees }}
                    </h1>

                    <div class="2xl:mx-11 xl:mx-11 xlg:mx-11 lg:mx-11 xmd:mx-11 md:mx-10 sm:mx-10 msm:mx-2 xsm:mx-5 xxsm:mx-5 2xl:mt-40 xl:mt-40 xlg:mt-40 lg:mt-40 xmd:mt-40 md:mt-40 sm:mt-40 msm:mt-10 xsm:mt-5 xxsm:mt-10">
                        <a href="javascript:void(0)" class="text-primary add-favourite" data-id="{{ $doctor['id'] }}"><i class="{{ $doctor['is_fav'] == 'true' ? 'fa fa-bookmark' : 'fa-regular fa-bookmark' }} border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        @if(auth()->user())
                        <a href="mailto:{{ $doctor->user['email'] }}" class="text-primary"><i class="fa fa-envelope border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        <a href="tel:{{ $doctor->phone }}" class="text-primary"><i class="fa-solid fa-phone border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        @else
                        <a href="/patient-login" class="text-primary" title={{__('Login to view') }}><i class="fa fa-envelope border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        <a href="/patient-login" class="text-primary" title={{__('Login to view') }}><i class="fa-solid fa-phone border border-primary 2xl:p-2 xl:p-2 xlg:p-2 lg:p-2 xmd:p-1 xxsm:p-2"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- main container --}}
    <div class="xl:w-3/4 mx-auto">
        {{-- first div --}}
        <div class="flex 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:row sm:flex-col  sms:flex-col  xsm:flex-col  xxsm:flex-col">
            {{-- first part --}}
            <div class="lg:w-[70%] xmd:w-[60%]  border-r border-white-light">
                <div class="border-b border-white-light  pb-6 pt-6">
                    <h1 class="text-xl font-normal leading-6 font-fira-sans text-black pb-4">{{__('Overview')}}</h1>
                    <p class="leading-4 font-fira-sans font-normal text-sm text-gray">{!! nl2br( $doctor->desc) !!}</p>
                </div>
                <div class="border-b border-white-light pb-6">
                    <h1 class="text-xl font-medium leading-6 font-fira-sans text-black pt-6">{{__('Education')}}</h1>
                    @foreach (json_decode($doctor->education) as $education)
                    <div class="flex pt-4">
                        <div>
                            <img src="{{asset('assets/image/Education.png')}}" class="" alt="">
                        </div>
                        <div class="mx-5">
                            <h1 class="font-normal text-sm font-fira-sans leading-4">{{ $education->college }}</h1>
                            <p class="font-fira-sans font-normal leading-3 text-xs text-gray py-1">{{ $education->degree }}
                            </p>
                            <p class="font-fira-sans font-normal leading-3 text-xs text-gray">{{ $education->year }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-b border-white-light pb-14">
                    <h1 class="text-xl font-medium leading-6 font-fira-sans text-black pt-6">{{__('Certificate')}}</h1>
                    @foreach (json_decode($doctor->certificate) as $certificate)
                    <div class="flex pt-4">
                        <div>
                            <img src="{{asset('assets/image/Experience.png')}}" class="" alt="">
                        </div>
                        <div class="mx-5">
                            <h1 class="font-normal text-sm font-fira-sans leading-4">{{ $certificate->certificate }}</h1>
                            <p class="font-fira-sans font-normal leading-3 text-xs text-gray py-1">{{
                            $certificate->certificate_year }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- second part --}}
            <div class="lg:w-[30%] xmd:w-[40%] border-b-0 mb-10 border-white-light ml-2">
                <div class="xmd:pl-[10px] pt-6 xxsm:pl-0">
                    <h1 class="text-xl font-normal leading-6 font-fira-sans text-black pb-4">{{__('Availablity')}}</h1>
                    <h1 class="font-fira-sans leading-5 text-base font-medium text-black">{{__('Today\'s Available Slots')}}
                    </h1>
                    <div class="flex flex-wrap h-48 overflow-hidden	overflow-y-scroll mt-5">
                        <div class="flex flex-wrap">
                            @if (count($today_timeslots) > 0)
                            @foreach ($today_timeslots as $today_timeslot)
                            <a href="javascript:void(0)" class="cursor-default border border-gray-light text-center 2xl:text-sm sm:text-sm msm:text-sm font-fira-sans font-normal xl:text-xs xlg:text-xs text-black m-1 w-20 h-9 pt-2">{{
                            $today_timeslot['start_time'] }}</a>
                            @endforeach
                            @else
                            <strong class="text-red-600 text-bs text-center w-100">{{__('At this time doctor is not
                            available') }}</strong>
                            @endif
                        </div>
                    </div>

                    <h1 class="font-fira-sans leading-5 text-base font-medium text-black pt-4 mt-2">{{__('Tomorrow’s
                    Available Slots')}}</h1>
                    <div class="flex flex-wrap h-48 overflow-hidden	overflow-y-scroll mt-5">
                        <div class="flex flex-wrap">
                            @foreach ($tomorrow_timeslots as $tomorrow_timeslot)
                            <a href="javascript:void(0)" class="cursor-default border border-gray-light text-center 2xl:text-sm sm:text-sm msm:text-sm font-fira-sans font-normal xl:text-xs xlg:text-xs text-black m-1 w-20 h-9 pt-2">{{
                            $tomorrow_timeslot['start_time'] }}</a>
                            @endforeach
                        </div>
                    </div>
                    {{-- <hr class="mt-3 border border-white-light"> --}}
                    <div class="">
                        <h1 class="text-xl font-normal leading-6 font-fira-sans text-black pt-10">{{__('Business Hours')}}
                        </h1>
                        <div class="flex 2xl:flex-row xl:flex-row xlg:flex-col lg:flex-row xsm:flex-row xxsm:flex-row justify-between items-start mt-5 pt-3 pb-3 2xl:px-3 bg-light-green">
                            <div class="">
                                <h1 class="text-base font-fira-sans leading-5 font-normal text-black"><span class="text-primary">{{__('Today • ')}}</span> {{ $today_date[0] }}</h1>
                                @foreach (json_decode($today_date[1]) as $itemssss)
                                <p class="font-fira-sans leading-4 text-sm font-normal text-gray pt-2">
                                    {{$itemssss->start_time.' - '.$itemssss->end_time}}
                                </p>
                                @endforeach
                            </div>
                            <div class="xlg:pt-2">
                                <a href="javascipt:void(0)" class="text-white {{ $today == 1 ? 'bg-primary' : 'bg-red'  }} text-center py-2 px-2 text-xs font-normal leading-3 font-fira-sans rounded-full">{{$today == 1 ? 'Open Now' : 'Closed' }}</a>
                            </div>
                        </div>

                        <div class="">
                            @foreach ($doctor->workHour as $workHour)
                            <div class="flex justify-between pt-5 flex-row">
                                <h1 class="font-fira-sans text-left text-sm font-medium text-black">{{ $workHour->day_index
                                }}</h1>
                                <div class="w-36">
                                    @foreach (json_decode($workHour['period_list']) as $period_list)
                                    @if ($workHour->status)
                                    <p class="font-fira-sans text-right text-sm font-normal text-gray ">
                                        {{$period_list->start_time.' - '.$period_list->end_time}}
                                    </p>
                                    @else
                                    <div>
                                        <p class="font-fira-sans leading-4 text-sm font-normal text-red pt-2">{{__('Closed')}}</p>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="border-1 border-white-light">
        {{-- second div --}}
        <div class="flex pb-14 2xl:mx-0 xl:mx-16 xlg:mx-0 lg:mx-0 xmd:mx-0 md:mx-5 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:row sm:flex-col sm:mx-5 sms:flex-col msm:mx-0 xsm:flex-col xsm:mx-0 xxsm:flex-col xxsm:mx-0">
            {{-- first part --}}
            <div class="w-1/2 border-b border-white-light md:w-full sm:w-full msm:w-full xsm:w-full xxsm:w-full">
                <h1 class="font-fira-sans font-normal text-xl leading-5 pt-10 pb-6">{{__('Locations')}}</h1>
                <div class="mr-10 space-y-5 ">
                    @foreach ($doctor->hospital as $hospital)
                    <div class="border-b border-white-light">
                        <h1 class="font-fira-sans text-base font-medium leading-5">{{ $hospital->name }}</h1>
                        <p class="font-fira-sans font-normal text-sm text-gray leading-5 py- mt-2">{{ $hospital->facility }}</p>
                        <p class="font-fira-sans font-normal text-sm text-black leading-5 py-1 mt-2 mb-2.5"><i class="fa-solid fa-location-dot"></i> {{ $hospital->address }}</p>
                        @php
                        $url = 'https://www.google.com/maps/dir/?api=1&destination='.$hospital->lat.','.$hospital->lng;
                        @endphp

                        <a href="{{ $url }}" target="_blank" class="font-fira-sans text-sm font-medium text-primary leading-5 py-2">{{__('Get
                        Directions')}}</a>

                        <div class="flex space-x-1 mb-5">
                            @foreach ($hospital->hospital_gallery as $gallery)
                            <a href="{{ $gallery->full_image }}" data-fancybox="gallery2">
                                <img src="{{ $gallery->full_image }}" class="w-10 h-10 rounded" alt="">
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- second part --}}
            <div class="w-1/2  border-l border-white-light md:w-full sm:w-full msm:w-full xxsm:w-full">
                <div class="2xl:pt-10 xxsm:pt-5">
                    <div class="flex justify-between ml-10 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row md:flex-row sm:flex-row xsm:flex-row xxsm:flex-col">
                        <div>
                            <h1 class="font-fira-sans font-medium text-xl leading-5">{{__('Reviews')}}</h1>
                        </div>
                    </div>

                    <div class="border-b border-white-light">
                        <div class="flex flex-row ml-10 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row md:flex-row sm:flex-row xsm:flex-col xxsm:flex-col">
                            <div class="flex flex-row space-x-10 py-10 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row md:flex-row sm:flex-row xsm:flex-row xxsm:flex-col">
                                <div>
                                    <h1 class="text-7xl font-fira-sans leading-10" style="color:#F2AE00">{{ $doctor->rate }}</h1>
                                </div>
                                <div class="xxsm:mt-10 2xl:mt-0 xsm:mt-0">
                                    <div class="flex space-x-5 justify-end">
                                        @for ($i = 0; $i < 5; $i++) <p class="text-gray font-fira-sans">*</p>
                                            @endfor
                                    </div>
                                    <div class="flex space-x-5 justify-end">
                                        @for ($i = 0; $i < 4; $i++) <p class="text-gray font-fira-sans">*</p>
                                            @endfor
                                    </div>
                                    <div class="flex space-x-5 justify-end">
                                        @for ($i = 0; $i < 3; $i++) <p class="text-gray font-fira-sans">*</p>
                                            @endfor
                                    </div>
                                    <div class="flex space-x-5 justify-end">
                                        @for ($i = 0; $i < 2; $i++) <p class="text-gray font-fira-sans">*</p>
                                            @endfor
                                    </div>
                                    <div class="flex space-x-5 justify-end">
                                        @for ($i = 0; $i < 1; $i++) <p class="text-gray font-fira-sans">*</p>
                                            @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="px-5 py-12 w-full">
                                <div class="bg-gray-light rounded-full h-1.5 mb-4 dark:bg-gray-light">
                                    <div class="h-1.5 rounded-full" style="width:{{ $rating_five_pr }}%;background-color:#F2AE00"></div>
                                </div>
                                <div class="bg-gray-light rounded-full h-1.5 mb-4 dark:bg-gray-light">
                                    <div class=" h-1.5 rounded-full" style="width:{{ $rating_four_pr }}%;background-color:#F2AE00"></div>
                                </div>
                                <div class="bg-gray-light rounded-full h-1.5 mb-4 dark:bg-gray-light">
                                    <div class=" h-1.5 rounded-full" style="width:{{ $rating_three_pr }}%;background-color:#F2AE00"></div>
                                </div>
                                <div class="bg-gray-light rounded-full h-1.5 mb-4 dark:bg-gray-light">
                                    <div class=" h-1.5 rounded-full" style="width:{{ $rating_two_pr }}%;background-color:#F2AE00"></div>
                                </div>
                                <div class="bg-gray-light rounded-full h-1.5 mb-4 dark:bg-gray-light">
                                    <div class=" h-1.5 rounded-full" style="width:{{ $rating_one_pr }}%;background-color:#F2AE00"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="reviewsContainer">
                    <div class="mt-3" id="show_review">
                        @foreach ($reviews as $review)
                        <div class="border-b border-white-light mt-5">
                            <div class="ml-10 flex justify-between mb-5">
                                <div class="flex w-[85%]">
                                    <img src="{{ $review->user['fullImage'] }}" class="w-10 h-10 rounded-full" alt="">
                                    <div class="ml-2">
                                        <span class="font-medium">{{ $review->user['name'] }}</span>
                                        <div class="mb-2">
                                            @for ($i = 1; $i < 6; $i++) @if ($i <=$review->rate)
                                                <i class="fa-solid fa-star" style="color:#F2AE00"></i>
                                                @else
                                                <i class="fa-solid fa-star"></i>
                                                @endif
                                                @endfor
                                        </div>
                                        <p class="font-fira-sans font-normal text-sm text-gray">{{$review->review}}</p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray">
                                    {{ $review->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex justify-end mt-5">
                        {{$reviews->links('vendor.pagination.bootstrap-4')}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection

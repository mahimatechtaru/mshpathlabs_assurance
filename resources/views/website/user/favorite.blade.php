@extends('layout.mainlayout',['activePage' => 'user'])

@section('css')
<style>
    .sidebar li.active {
        background: linear-gradient(45deg, #00000000 50%, #f4f2ff);
        border-left: 2px solid var(--site_color);
    }
</style>
@endsection

@section('content')
<div class="xl:w-3/4 mx-auto pt-10">
    <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0">
        <div class="flex mb-20 xxsm:flex-col sm:flex-col md:flex-row xmd:space-x-5">
            <div class="2xl:w-1/5 1xl:w-1/5 xl:w-1/4 xlg:w-80 lg:w-72 xxmd:w-72 !xmd:w-72 md:w-72 h-auto">
                @include('website.user.userSidebar',['active' => 'favirote'])
            </div>
            <div class="w-full md:w-full xxmd:w-full xmd:w-80 lg:w-2/3 xlg:w-2/3 1xl:w-full 2xl:w-full sm:ml-0 xxsm:ml-0 shadow-lg overflow-hidden p-5 mt-10 2xl:mt-0 xmd:mt-0">
                @if(count($doctors) > 0)
                @foreach ($doctors as $doctor)
                <div class="hoverDoc h-auto mt-8 p-3 border border-white-100">
                    <div class="flex 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-col sm:flex-col msm:flex-col xsm:flex-col xxsm:flex-col w-full">
                        <div class="w-full h-full">
                            <div class="flex flex-col justify-center items-center">
                                <img class="2xl:w-28 2xl:h-28 xlg:h-24 xlg:w-24 xl:h-24 xl:w-24 lg:h-24 lg:w-24 md:h-24 md:w-24 sm:h-24 sm:w-24 xsm:h-20 xsm:w-20 msm:h-20 msm:w-20 xxsm:h-20 xxsm:w-20 border border-primary rounded-full p-0.5" src="{{ url($doctor['fullImage']) }}" alt="" />
                                <h5 class="font-fira-sans font-normal text-xl leading-6 text-black-dark text-center pt-5">{{ $doctor['name'] }}</h5>
                                <p class="font-normal leading-4 text-sm text-primary text-center font-fira-sans py-2">{{ $doctor['treatment']['name'] }}</p>
                                <p class="font-normal leading-4 text-sm text-gray text-center"><i class="fa-solid fa-star text-yellow"></i> {{ $doctor['rate'] }} ({{ $doctor['review'] }}{{ __(' reviews') }})</p>
                            </div>
                        </div>
                        <div class="w-full h-full border-l border-white-light pl-5 relative">
                            <div data-id="{{ $doctor['id'] }}" class="right-0 cursor-pointer absolute flex align-center justify-center shadow-1xl add-favourite p-3 rounded-full text-primary">
                                <i class="{{ $doctor['is_fav'] == 'true' ? 'fa fa-bookmark' : 'fa-regular fa-bookmark' }}"></i>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="pr-5">
                                    <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-5">{{ $doctor['treatment']['name'] }}</p>
                                    @foreach ($doctor['hospital'] as $hospital)
                                    <p class="font-fira-sans font-medium text-base leading-5 text-black-dark text-left pt-3">{{ $hospital['name'] }}</p>
                                    <p class="font-fira-sans font-normal text-sm leading-4 text-gray text-left pt-2"><span class="mr-2"><i class="fa-solid fa-location-dot"></i></span class="ml-2">{{ $hospital['address'] }}</p>
                                    @endforeach
                                    <h1 class="font-fira-sans font-semibold text-xl text-primary leading-7 pt-5 xmd:pt-2 sm:pt-1">{{ $currency }}{{ $doctor['appointment_fees'] }}</h1>
                                </div>
                                <div class="flex mt-5 mb-2">
                                    <a href="{{ url('booking/'.$doctor['id'].'/'.Str::slug($doctor['name'])) }}" class="font-fira-sans lg:px-1 lg:w-44 xsm:w-36 md:px-3 text-sm xl:py-3 xlg:py-3 xl:px-4 xlg:px-4 lg:py-3 xmd:py-1 md:py-3 sm:py-3 sm:px-2 msm:py-2 msm:px-3 xsm:px-3 xsm:py-2 xxsm:py-2 xxsm:px-3 text-white bg-primary hover:bg-primary text-center">{{__('Make Appointment')}}</a>
                                    <a href="{{ url('doctor-profile/'.$doctor['id'].'/'.Str::slug($doctor['name'])) }}" class="font-fira-sans text-primary text-sm font-normal leading-4 underline 2xl:mx-5 xl:mx-5 xlg:mx-2 lg:mx-2 md:mx-5 lg:py-3 xmd:py-2 md:py-2 sm:py-0 msm:py-2 xsm:py-2 xxsm:py-2">{{__('View Profile')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="flex justify-center mt-44 font-fira-sans font-normal text-base text-gray">
                    {{__('No Data Available')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

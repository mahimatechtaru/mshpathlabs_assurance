@extends('layout.mainlayout',['activePage' => 'pharmacy'])

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
{{-- Your Home For Health --}}
<div class="pt-14 border-b border-gray-light mb-10 pb-10">
    <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10">{{__('Your Home For')}} <span class="text-primary">{{__('Health')}}</span></h1>
    <div class="p-5">
        <p class="font-fira-sans font-normal text-lg text-center leading-5 text-gray">{{__('Find Better. Appoint Better')}}</p>
    </div>
    {{-- Search bar --}}
    <form id="searchForm" method="post">
        @csrf
        <div class="flex justify-center  2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-col
        xsm:flex-col xxsm:flex-col space-x-5 xmd:space-y-0 sm:space-y-0 sm:space-x-5 msm:space-x-0 xsm:space-x-0 xxsm:space-x-0 msm:p-5 msm:space-y-2 xsm:space-y-2 xsm:p-5
        xxsm:space-y-2 xxsm:p-2">
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="search" name="search_pharmacy" id="search_pharmacy" class="block p-2 pl-10 text-sm bg-white-50 border border-white-light 2xl:w-96 xmd:w-72 !sm:w-36 h-12" placeholder="{{__('Search Pharmacy...')}}" required>
            </div>
            <input type="hidden" name="from" value="js">
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <input type="search" name="address" onFocus="geolocate()" id="autocomplete" class="block p-2 pl-10 text-sm bg-white-50 border border-white-light 2xl:w-96 xmd:w-72 !sm:w-36 h-12" placeholder="{{__('Set your location')}}" required>
                <input type="hidden" name="pharmacy_lat">
                <input type="hidden" name="pharmacy_lang">
            </div>
            <button type="button" onclick="searchPharmacy()"  class="text-white bg-primary text-center px-6 py-2 text-base font-normal leading-5 font-fira-sans sm:w-32 msm:w-32 xsm:w-32 xxsm:w-32 h-12"><i class="fa-solid fa-magnifying-glass"></i> {{__('Search')}}</button>
        </div>
    </form>
</div>

<div class="xl:w-3/4 mx-auto mb-16">
    <div class="flex pt-5 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row xsm:flex-col xxsm:flex-col">
        {{-- side bar --}}
        <div class="2xl:w-1/4 xl:w-1/4 xlg:w-1/4 lg:w-1/4 px-4 space-y-7 py-5 sm:w-60">
            <form id="filter_form">
                <div>
                    <h1 class="font-fira-sans font-medium text-base leading-5 text-black-dark">{{__('Categories')}}</h1>

                    <div class="form-check p-1">
                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-light rounded-sm bg-white-50 checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" name="select_specialist" type="checkbox" value="popular" id="popular">
                        <label class="form-check-label font-fira-sans font-normal text-sm leading-4 inline-block text-gray-800" for="popular">
                            {{ __('Popular') }}
                        </label>
                    </div>
                    <div class="form-check p-1">
                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-light rounded-sm bg-white-50 checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" name="select_specialist" type="checkbox" value="latest" id="latest">
                        <label class="form-check-label font-fira-sans font-normal text-sm leading-4 inline-block text-gray-800" for="latest">
                            {{ __('Latest') }}
                        </label>
                    </div>
                    <div class="form-check p-1">
                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-light rounded-sm bg-white-50 checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" name="select_specialist" type="checkbox" value="availability" id="availability">
                        <label class="form-check-label font-fira-sans font-normal text-sm leading-4 inline-block text-gray-800" for="availability">
                            {{ __('Availability') }}
                        </label>
                    </div>
                </div>
            </form>
        </div>
        {{-- center images --}}
        <div class="w-full xxsm:p-5 xl:p-0 2xl:p-0">
        @if (count($pharmacies['data'])>0)
            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 xlg:grid-cols-3 dispPharmacy">
                @include('website.display_pharmacy')
            </div>
        @else
            <div class="flex justify-center mt-10 font-fira-sans font-normal text-base text-gray">
                {{__('No Data Available')}}
            </div>
        @endif
        </div>
    </div>
    {{-- view more --}}
    @if (count($pharmacies)>0)
        @if ($pharmacies['current_page'] != $pharmacies['last_page'])
            <div class="flex justify-center pt-8 pb-32 2xl:ml-64 xl:ml-72 xlg:ml-64 lg:ml-54 xmd:ml-44 sm:ml-20 xsm:ml-5 xxsm:ml-4">
                <div class="sm:py-3 md:py-0 msm:py-3 xsm:py-3 xxsm:py-3" id="">
                    <button id="more-doctor" type="button" class="text-sm font-normal font-fira-sans leading-4 md:text-sm text-primary border border-primary text-center py-3.5 px-6">{{__('View More')}}</button>
                </div>
            </div>
        @endif
    @else
    @endif
</div>
@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{ App\Models\Setting::first()->map_key }}&sensor=false&libraries=places"></script>
<script src="{{ url('assets/js/pharmacy.js') }}"></script>
@endsection

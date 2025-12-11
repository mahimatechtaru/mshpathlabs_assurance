@extends('layout.mainlayout', ['activePage' => 'doctors'])

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
    <div class="pt-14 border-b border-white-light mb-10 pb-10">
        <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10">{{ __('Your Home For') }} <span
                class="text-primary">{{ __('Health') }}</span></h1>
        <div class="p-5">
            <p class="font-fira-sans font-normal text-lg text-center leading-5 text-gray">
                {{ __('Find Better. Appoint Better') }}</p>
        </div>
        {{-- Search bar --}}
        <form action="{{ url('show-doctors') }}" id="searchForm" method="post">
            @csrf
            <div class="flex justify-center 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-col
                xsm:flex-col xxsm:flex-col space-x-5 xmd:space-y-0 sm:space-y-0 sm:space-x-5 msm:space-x-0 xsm:space-x-0 xxsm:space-x-0 msm:p-5 msm:space-y-2 xsm:space-y-2 xsm:p-5 xxsm:space-y-2 xxsm:p-2">
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="search" name="search_doctor" class="block p-2 pl-10 text-sm text-black-700 bg-white-50 border border-white-light 2xl:w-96 xmd:w-72 !sm:w-32 msm:w-40 h-12" placeholder="{{ __('Search Doctor...') }}">
                </div>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <input type="hidden" name="from" value="js">
                    <input type="search" onFocus="geolocate()" id="autocomplete"
                        class="block p-2 pl-10 text-sm text-black-700 bg-white-50 border border-white-light 2xl:w-96 xmd:w-72 !sm:w-32 msm:w-40 h-12"
                        placeholder="{{ __('Set your location') }}">
                    <input type="hidden" name="doc_lat">
                    <input type="hidden" name="doc_lang">
                </div>
                <button type="button" onclick="searchDoctor()" class="text-white bg-primary text-center px-6 py-2 text-base font-normal leading-5 font-fira-sans sm:w-32 msm:w-32 xsm:w-32 xxsm:w-32 h-12"><i
                        class="fa-solid fa-magnifying-glass"></i> {{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <div class="xl:w-3/4 mx-auto">
        <div class="flex pt-5 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row xsm:flex-col xxsm:flex-col">
            {{-- side bar --}}
            <div class="2xl:w-1/4 xl:w-1/4 xlg:w-1/4 lg:w-1/4 sm:w-72 px-4 py-5">
                <form id="filter_form" method="post">
                    <div class="flex justify-center">
                        <div class="w-full">
                            <select name="sort_by"
                                class="form-select appearance-none block w-full px-3 py-1.5 text-sm font-normal text-gray bg-white-50 bg-clip-padding bg-no-repeat border border-solid border-white-light transition ease-in-out m-0 focus:text-gray-700 focus:bg-white-50 focus:border-primary focus:outline-none"
                                aria-label="Default select example">
                                <option value="" selected>{{ __('Sort By') }}</option>
                                <option value="rating">{{ __('Rating') }}</option>
                                <option value="popular">{{ __('Popular') }}</option>
                                <option value="latest">{{ __('Latest') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-2">
                        <h1 class="font-fira-sans font-medium text-base leading-5 text-black-dark mt-5">{{ __('Gender') }}
                        </h1>
                        <div class="form-check p-1">
                            <input class=""
                                name="gender_type" type="radio" value="male" id="male">
                            <label class="font-fira-sans form-check-label inline-block font-normal text-black text-sm leading-4"
                                for="male">
                                {{ __('Male') }}
                            </label>
                        </div>
                        <div class="form-check p-1">
                            <input
                                class=" "
                                name="gender_type" type="radio" value="female" id="female">
                            <label
                                class="font-fira-sans form-check-label inline-block font-normal text-black text-sm leading-4"
                                for="female">
                                {{ __('Female') }}
                            </label>
                        </div>
                    </div>
                    <div>
                        <h1 class="font-fira-sans font-medium text-base leading-5 text-black-dark mt-5">
                            {{ __('Select Specialist') }}
                        </h1>
                        @foreach ($categories as $category)
                            <div class="form-check p-1">
                                <input name="select_specialist"
                                    class="form-check-input appearance-none h-4 w-4 border border-white-light rounded-sm bg-white checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    type="checkbox" value="{{ $category->id }}" id="category{{ $category->id }}">
                                <label
                                    class="font-fira-sans form-check-label inline-block font-normal text-black text-sm leading-4"
                                    for="category{{ $category->id }}">
                                    {{ __($category->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>

            <div class="w-full">
                @if (count($doctors['data']) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 xlg:grid-cols-2 lg:grid-cols-2 2xl:grid-cols-3 dispDoctor">
                        @include('website.display_doctors', ['doctor' => $doctors])
                    </div>
                @else
                    <div class="flex justify-center mt-10 font-fira-sans font-normal text-base text-gray">
                        {{ __('No Data Available') }}
                    </div>
                @endif
            </div>
        </div>
        @if (count($doctors) > 0)
            @if ($doctors['current_page'] != $doctors['last_page'])
                <div
                    class="flex justify-center pt-8 pb-32 2xl:ml-64 xl:ml-72 xlg:ml-64 lg:ml-54 xmd:ml-44 sm:ml-20 xsm:ml-5 xxsm:ml-4">
                    <div class="sm:py-3 md:py-0 msm:py-3 xsm:py-3 xxsm:py-3" id="">
                        <button id="more-doctor" type="button"  class="text-sm font-normal font-fira-sans leading-4 md:text-sm text-primary border border-primary text-center py-3.5 px-6">{{ __('View More') }}</button>
                    </div>
                </div>
            @endif
        @else
        @endif
    </div>
@endsection
@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ App\Models\Setting::first()->map_key }}&sensor=false&libraries=places">
    </script>
    <script src="{{ url('assets/js/doctor_list.js') }}"></script>
@endsection

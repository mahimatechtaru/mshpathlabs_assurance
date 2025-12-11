@extends('layout.mainlayout',['activePage' => 'pharmacy'])

@section('css')
<style>
    .displayMedicine:hover .cart {
        color: white;
        background-color: var(--site_color);
        padding: 8px 13px;
        border-radius: 50%
    }

    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="xl:w-3/4 mx-auto">
    <input type="hidden" name="pharmacy_id" value="{{ $pharmacy->id }}">
    <input type="hidden" name="pharmacy_name" value="{{ Str::slug($pharmacy->name) }}">
    <div class="flex pt-5 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-rowmd:flex-row sm:flex-row xsm:flex-col xxsm:flex-col">
        <div class="2xl:w-1/4 xl:w-1/4 xlg:w-80 lg:w-1/4 sm:w-96  px-4 py-5">
            <div class="flex justify-center">
                <div class="mb-3 xl:w-96">
                    <div class="flex">
                        <div class="relative w-full">
                            <input type="search" id="search-dropdown" name="medicine_name" class="block p-2.5 w-full z-20 text-sm text-gray-900 font-fira-sans border-[#D8D8D8]" placeholder="Search" required>
                            <button type="button" onclick="medicineSearch()" class="btn absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 border font-fira-sans">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form id="filter_form" class="mt-3" method="post">
                <div>
                    <h1 class="font-fira-sans font-md text-base leading-5 font-medium mb-2 text-black-dark uppercase ">{{__('Categories')}}</h1>
                    @foreach ($categories as $category)
                        <div class="form-check p-1">
                            <input name="select_specialist" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white-50 checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="{{ $category->id }}" id="category{{ $category->id }}">
                            <label class="font-fira-sans form-check-label inline-block text-gray-800" for="category{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="w-full px-4 py-5">
        @if(count($medicines['data']) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 display_medicine">
                @include('website.display_medicine')
            </div>
        @else
            <div class="flex justify-center mt-44 font-fira-sans font-normal text-base text-gray">
                {{__('No Data Available')}}
            </div>
        @endif
        </div>
    </div>
    @if (count($medicines)>0)
        @if ($medicines['current_page'] != $medicines['last_page'])
        <div
            class="flex justify-center pt-8 pb-32 2xl:ml-64 xl:ml-72 xlg:ml-80 lg:ml-64 xmd:ml-44 sm:ml-20 xsm:ml-5 xxsm:ml-4">
            <div class="sm:py-3 md:py-0 msm:py-3 xsm:py-3 xxsm:py-3">
                <button type="button" id="more-doctor"
                    class="text-sm font-normal font-fira-sans leading-4 md:text-sm text-primary border border-primary text-center py-3.5 px-6">{{__('View More')}}</button>
            </div>
        </div>
        @endif
    @else
    @endif
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/pharmacy_list.js') }}"></script>
<script src="{{ asset('assets/js/medicine_list.js') }}"></script>
@endsection

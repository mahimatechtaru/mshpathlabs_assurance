@extends('layout.mainlayout',['activePage' => 'labs'])

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
    <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10">{{__('Laboratory ')}}</h1>
    <div class="p-5">
        <p class="font-fira-sans font-normal text-lg text-center leading-5 text-gray">{{__('Book Your Appointment with Easy Way')}}</p>
    </div>
    <form id="searchForm" method="post">
        <div class="flex justify-center  2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row msm:flex-col xsm:flex-col xxsm:flex-col space-x-5 xmd:space-y-0 sm:space-y-0 sm:space-x-5 msm:space-x-0 xsm:space-x-0 xxsm:space-x-0 msm:p-5 msm:space-y-2 xsm:space-y-2 xsm:p-5 xxsm:space-y-2 xxsm:p-2">
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="search" name="search_val" id="default-search" class="block p-2 pl-10 text-sm border border-white-light 2xl:w-96 xmd:w-72 sm:w-40 h-12" placeholder="{{__('Search Laboratory...')}}" required>
            </div>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <input type="search" name="address" id="autocomplete" onFocus="geolocate()" class="block p-2 pl-10 text-sm border border-white-light 2xl:w-96 xmd:w-72 sm:w-40 h-12" placeholder="{{__('Set your location')}}" required>
                <input type="hidden" name="lab_lat">
                <input type="hidden" name="lab_lang">
            </div>
            <input type="hidden" name="from" value="js">
            <button type="button" onclick="labSearch()" class="text-white bg-primary text-center px-6 py-2 text-base font-normal leading-5 font-fira-sans sm:w-32 msm:w-32 xsm:w-32 xxsm:w-32 h-12"><i class="fa-solid fa-magnifying-glass"></i> {{__('Search')}}</button>
        </div>
    </form>
</div>

<div class="xl:w-3/4 mx-auto mb-16">
    <div class="flex pt-5 2xl:flex-row xl:flex-row xlg:flex-row lg:flex-row xmd:flex-row md:flex-row sm:flex-row xsm:flex-col xxsm:flex-col xxsm:mx-5 xl:mx-0 2xl:mx-0">
        <div class="2xl:w-1/4 xl:w-1/4 xlg:w-1/4 lg:w-1/4 sm:w-60 px-4 space-y-7 py-5">
            <form id="filter_form">
                <div>
                    <h1 class="font-fira-sans font-medium text-base leading-5 text-black-dark">{{__('Categories')}}</h1>
                    <div class="form-check p-1">
                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-light rounded-sm bg-white-50 checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" name="select_specialist" type="checkbox" value="latest" id="latest">
                        <label class="form-check-label font-fira-sans font-normal text-sm leading-4 inline-block text-black" for="latest"> {{__('Latest') }}
                        </label>
                    </div>
                    <div class="form-check p-1">
                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-light rounded-sm bg-white-50 checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" name="select_specialist" type="checkbox" value="availability" id="availability">
                        <label class="form-check-label font-fira-sans font-normal text-sm leading-4 inline-block text-black" for="availability">
                            {{__('Availability') }}
                        </label>
                    </div>
                </div>
            </form>
        </div>
        <div class="w-full">
            @if (count($labs['data'])>0)
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 dispLabs">
                @include('website.display_labs')
            </div>
            @else
            <div class="flex justify-center mt-10 font-fira-sans font-normal text-base text-gray">
                {{__('No Data Available')}}
            </div>
            @endif
        </div>
    </div>
    {{-- view more --}}
    @if (count($labs)>0)
    @if ($labs['current_page'] != $labs['last_page'])
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

<script src="https://maps.googleapis.com/maps/api/js?key={{ App\Models\Setting::first()->map_key }}&sensor=false&libraries=places">
</script>
<script>
    $(document).ready(function() {
        var page = 1;
        $("#more-doctor").click(function() {
            page++;
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '?page=' + page,
                    type: 'post',
                })
                .done(function(data) {
                    if (data.meta.current_page == data.meta.last_page) {
                        $('#more-doctor').hide();
                    } else {
                        $('#more-doctor').show();
                    }
                    $('.dispLabs').append(data.html);
                })
                .fail(function(jqXHR, ajaxOptions, throwError) {
                    alert('Server error');
                })
        });

        $("#filter_form").change(function() {
            categories = [];
            $('input[name="select_specialist"]:checked').each(function(i) {
                if (categories.indexOf(this.value) === -1)
                    categories.push(this.value);
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {
                    category: categories,
                    from: 'js',
                    lab_lat: $('input[name=lab_lat]').val(),
                    lab_lang: $('input[name=lab_lang]').val(),
                    search_val: $('input[name=search_val]').val(),
                },
                url: "{{url('/all-labs')}}",
                success: function(result) {
                    $('.dispLabs').html('');
                    $('.dispLabs').append(result.html);
                    $('#more-doctor').hide();
                },
                error: function(err) {

                }
            });
        });
    });

    function geolocate() {
        var autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */
            (document.getElementById('autocomplete')), {
                types: ['geocode']
            });
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var lat = autocomplete.getPlace().geometry.location.lat();
            var lang = autocomplete.getPlace().geometry.location.lng();
            $('input[name=lab_lat]').val(lat);
            $('input[name=lab_lang]').val(lang);
        });
    }

    function labSearch() {
        var categories = [];
        $('input[name="select_specialist"]:checked').each(function(i) {
            if (categories.indexOf(this.value) === -1)
                categories.push(this.value);
        });
        var lab_lat = $('input[name=lab_lat]').val();
        var lab_lang = $('input[name=lab_lang]').val();
        var search_val = $('input[name=search_val]').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('/all-labs')}}",
            type: 'post',
            data: {
                category: categories,
                from: 'js',
                lab_lat: lab_lat,
                lab_lang: lab_lang,
                search_val: search_val,
            },
            success: function(result) {
                $('.dispLabs').html('');
                $('.dispLabs').append(result.html);
                $("#more-doctor").hide();
            },
            error: function(err) {

            }
        });
    }
</script>

@endsection

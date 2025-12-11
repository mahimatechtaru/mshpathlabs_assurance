<div class="bg-black w-full">
    <div class="xl:w-3/4 mx-auto pt-5">
        <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0">
            <div class="xxsm:pt-5 xxsm:pb-5 justify-between flex sm:flex-row xxsm:flex-col">
                <div>
                    <a href="{{ url('/') }}" class="">
                        @if($setting->company_white_logo && file_exists(public_path('images/upload/'.$setting->company_white_logo)))
                        <img src="{{ $setting->companyWhite }}" width="150px" height="40px" alt="Logo">
                        @else
                        <img src="{{url('/images/upload_empty/logo_white.png')}}" class="h-6 mr-3 sm:h-9" alt="Doctro Logo" />
                        @endif
                    </a>
                    <div class="flex pt-5">
                        <a href="{{ $setting->facebook_url }}" target="_blank" class=""><i class="fa-brands fa-facebook text-white border rounded-full p-2"></i></a>
                        <a href="{{ $setting->twitter_url }}" target="_blank" class="lg:mx-4 md:mx-2 xsm:mx-1 xxsm:mx-1"><i class="fa-brands fa-twitter text-white border rounded-full p-2"></i></a>
                        <a href="{{ $setting->instagram_url }}" target="_blank" class=""><i class="fa-brands fa-instagram text-white border rounded-full p-2"></i></a>
                        <a href="{{ $setting->linkdin_url }}" target="_blank" class="lg:mx-4 md:mx-2 xsm:mx-1 xxsm:mx-1"><i class="fa-brands fa-linkedin-in text-white border rounded-full p-2"></i></a>
                    </div>
                </div>
                <div class="grid msm:grid-cols-2 gap-10 xsm:grid-cols-1 xxsm:grid-cols-1 mb-5">
                    <div>
                        <h1 class="text-primary font-medium text-lg leading-5 font-fira-sans xxsm:pt-5 sm:pt-0">{{__('For Patients')}}</h1>
                        <div class="2xl:pt-10 xxsm:pt-5">
                            <a href="{{url('/show-doctors')}}" class="text-white text-sm font-normal leading-4 font-fira-sans pt-10">{{__('Search for Doctors')}}</a>
                        </div>
                        <div class="mt-2">
                            <a href="{{url('/all-pharmacies')}}" class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Pharmacy')}}</a>
                        </div>
                        <div class="mt-2">
                            <a href="{{url('/all-labs')}}" class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Lab Tests')}}</a>
                        </div>
                        <div class="mt-2">
                            <a href="{{url('/our-offers')}}" class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Offers')}}</a>
                        </div>
                        <div class="mt-2">
                            <a href="{{url('/our_blogs')}}" class="text-white text-sm font-normal leading-4 font-fira-sans pt-2">{{__('Blog')}}</a>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-primary font-medium text-lg leading-5 font-fira-sans msm:pt-5 sm:pt-0">{{__('Contact Us:')}}</h1>
                        <div class="2xl:pt-10 xxsm:pt-5">
                            <a href="tel:{{ $setting->phone }}" class="text-white text-sm leading-4 font-fira-sans font-normal underline pt-2">{{ $setting->phone }}</a>
                        </div>
                        <div class="mt-2">
                            <a href="mailto:{{ $setting->email }}" class="text-white text-sm leading-4 font-fira-sans font-normal underline pt-2">{{ $setting->email }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray pb-5 xxsm:mx-5 xl:mx-0 2xl:mx-0">
            <div class="xxsm:pt-5 justify-between flex sm:flex-row xxsm:flex-col w-[97%]">
                <p class="text-white text-sm font-normal leading-5 font-fira-sans mb-5">{{__('Copyright')}} &copy; {{ Carbon\Carbon::now(env('timezone'))->year }} {{ __($setting->business_name) }}{{__(', All rights reserved')}} </p>
                <div class="flex flex-row">
                    <div>
                        <a href="{{ url('zoom') }}" class="text-white text-sm font-normal leading-5 font-fira-sans mr-[80px]">{{__('Zoom')}}</a>
                    </div>
                    <div>
                        <a href="{{ url('about-us') }}" class="text-white text-sm font-normal leading-5 font-fira-sans mr-[80px]">{{__('About us')}}</a>
                    </div>
                    <div>
                        <a href="{{ url('privacy-policy') }}" class="text-white text-sm font-normal leading-5 font-fira-sans mr-12">{{__('Privacy Policy')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

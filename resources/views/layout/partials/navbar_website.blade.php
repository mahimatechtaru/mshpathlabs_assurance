<nav class="border-gray-200 sm:px-4 py-2.5 rounded border-b border-slate">
    <div class="msm:mx-0 xsm:mx-0 xxsm:mx-0 xlg:mx-20 2xl:mx-20">
        <div class="flex flex-wrap items-center justify-between mx-auto">
            <a href="{{ url('/') }}" class="flex items-center ml-2">
                @if($setting->company_logo && file_exists(public_path('images/upload/'.$setting->company_logo)))
                    <img src="{{$setting->logo}}" class="h-6 mr-3 sm:h-9" alt="Doctro Logo" />
                @else
                    <img src="{{url('/images/upload_empty/logo_black.png')}}" class="h-6 mr-3 sm:h-9" alt="Doctro Logo" />
                @endif
            </a>
            <div class="flex items-center md:order-2">
                @php
                if (Auth::check()){
                if (auth()->user()->language) {
                $lang_name = Auth::user()->language;
                $lang_image = App\Models\Language::where('name', $lang_name)->first()->image;
                }
                else{
                $lang_name = 'English';
                $lang_image = "English.png";
                }
                }
                else
                {
                $icon = \App\Models\Language::where('name',session('locale'))->first();
                if($icon)
                {
                $lang_name = session('locale');
                $lang_image = $icon->image;
                }
                else
                {
                $lang_name = 'English';
                $lang_image = "English.png";
                }
                }
                $languages = App\Models\Language::where('status',1)->get();
                @endphp
                <button type="button" data-dropdown-toggle="language-dropdown-menu" class="inline-flex items-center justify-center px-4 py-2 text-sm text-gray-500 rounded-lg cursor-pointer">
                    <img src="{{asset('images/upload/'.$lang_image)}}" class="w-5 h-5 mr-2 rounded-full" alt="">
                    {{ $lang_name }}
                </button>

                <div class="z-50 hidden my-4 text-base list-none divide-y divide-gray-100 rounded-lg shadow bg-white" id="language-dropdown-menu">
                    <ul class="py-2" role="none">
                        @foreach ($languages as $language)
                        <li>
                            <a href="{{ url('select_language',$language->id) }}" class="block px-4 py-2 text-sm text-black-700" role="menuitem">
                                <div class="inline-flex items-center">
                                    <img alt="Image placeholder" src=" {{asset('images/upload/'.$language->image)}}" class="h-3.5 w-3.5 rounded-full mr-2">
                                    {{ $language->name }}
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex items-center relative">
                    <div class="my-auto cart">
                        <a class="text-gray-500 hover:text-gray-700 focus:text-gray-700 mr-4 flex relative" href="{{ url('view-cart') }}">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 20C5.45 20 4.97933 19.8043 4.588 19.413C4.196 19.021 4 18.55 4 18C4 17.45 4.196 16.979 4.588 16.587C4.97933 16.1957 5.45 16 6 16C6.55 16 7.02067 16.1957 7.412 16.587C7.804 16.979 8 17.45 8 18C8 18.55 7.804 19.021 7.412 19.413C7.02067 19.8043 6.55 20 6 20ZM16 20C15.45 20 14.9793 19.8043 14.588 19.413C14.196 19.021 14 18.55 14 18C14 17.45 14.196 16.979 14.588 16.587C14.9793 16.1957 15.45 16 16 16C16.55 16 17.021 16.1957 17.413 16.587C17.8043 16.979 18 17.45 18 18C18 18.55 17.8043 19.021 17.413 19.413C17.021 19.8043 16.55 20 16 20ZM4.2 2H18.95C19.3333 2 19.625 2.17067 19.825 2.512C20.025 2.854 20.0333 3.2 19.85 3.55L16.3 9.95C16.1167 10.2833 15.8707 10.5417 15.562 10.725C15.254 10.9083 14.9167 11 14.55 11H7.1L6 13H18V15H6C5.25 15 4.68333 14.6707 4.3 14.012C3.91667 13.354 3.9 12.7 4.25 12.05L5.6 9.6L2 2H0V0H3.25L4.2 2Z" fill="#000" />
                            </svg>
                            <p class="absolute flex items-center justify-center tot_cart">{{Session::has('cart') ? count(Session::get('cart')) : 0 }}</p>
                        </a>
                    </div>

                    @if (auth()->check())
                    <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:mr-0 dark:text-white" type="button">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 mr-2 rounded-full" src="{{ url('images/upload/'.auth()->user()->image) }}" alt="user photo">
                        <div class="text-gray-500">{{ auth()->user()->name }}</div>
                        <svg class="w-4 h-4 mx-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <div id="dropdownAvatarName" class="bg-white z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44  dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                            <li>
                                <a href="{{ url('user_profile') }}" class="block px-4 py-2 font-fira-sans">{{ __('Dashboard') }}</a>
                            </li>
                        </ul>
                        <div class="py-2">
                            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm font-fira-sans">{{ __('Sign out') }}</a>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <div class="mt-auto mb-auto ml-3 xxsm:ml-0">
                        <a href="{{url('/patient-login')}}" class="rounded-none bg-primary tracking-wide px-4 py-2 text-white font-fira-sans font-normal text-sm">{{__('Sign In')}}</a>
                    </div>
                    @endif
                </div>
                <button data-collapse-toggle="mobile-menu-language-select" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden xxsm:block hover:bg-gray-100" aria-controls="mobile-menu-language-select" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" aria-hidden="true" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden items-center justify-between w-full md:flex md:w-auto md:order-1" id="mobile-menu-language-select">
                <ul class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0">
                    <li>
                        <a href="{{url('/show-doctors')}}" class="{{ $activePage == 'doctors' ? 'text-primary' : 'text-black' }} font-fira-sans block py-2 pl-3 pr-4 rounded md:bg-transparent md:p-0" aria-current="page">{{ __('Find Doctors') }}</a>
                    </li>
                    <li>
                        <a href="{{url('/all-pharmacies')}}" class="{{ $activePage == 'pharmacy' ? 'text-primary' : 'text-black' }} block py-2 font-fira-sans pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('Pharmacy') }}</a>
                    </li>
                    <li>
                        <a href="{{url('/all-labs')}}" class="{{ $activePage == 'labs' ? 'text-primary' : 'text-black' }} block py-2 font-fira-sans pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('Lab Tests') }}</a>
                    </li>
                    <li>
                        <a href="{{url('/our-offers')}}" class="{{ $activePage == 'offers' ? 'text-primary' : 'text-black' }} block py-2 font-fira-sans pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('Offers') }}</a>
                    </li>
                    <li>
                        <a href="{{url('/our_blogs')}}" class="{{ $activePage == 'ourblogs' ? 'text-primary' : 'text-black' }} block py-2 font-fira-sans pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('Blog') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

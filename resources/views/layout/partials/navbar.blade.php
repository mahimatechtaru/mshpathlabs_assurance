<div class="page-header sticky-header d-flex align-items-center">
    <div class="container-xl d-flex">

        <nav class="navbar content w-100 m-auto navbar-light navbar-expand-xl">
            <a class="navbar-brand order-xl-1 order-2" href="{{ url('/') }}">
                <img src="{{ url('images/upload/'.$setting->company_logo)}}" width="100px" alt="">
            </a>

            <button class="navbar-toggler  order-xl-2 order-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg" aria-controls="navbarOffcanvasLg">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-start order-xl-2 order-1 " tabindex="-1" id="navbarOffcanvasLg" aria-labelledby="navbarOffcanvasLgLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">{{ $setting->business_name }}</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav menubar  align-items-xl-center flex-grow-1">
                        <li class="nav-item nav-select {{ $active_page == 'doctors' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('show-doctors') }}">{{ __('Find Doctors') }}
                                <span>{{ __('Book an appointment') }}</span>
                            </a>
                        </li>

                        <li class="nav-item nav-select {{ $active_page == 'pharmacy' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column" href="{{ url('/all-pharmacies') }}">{{__('Pharmacy')}}
                                <span>{{__('Medicines & Health Product')}}</span>
                            </a>
                        </li>

                        <li class="nav-item nav-select {{ $active_page == 'lab_test' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('/labs') }}">{{__('Lab tests')}}
                                <span>{{__('Book tests & checkup')}}</span>
                            </a>
                        </li>

                        <li class="nav-item nav-select {{ $active_page == 'offer' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('all-offers') }}">{{ __('Offers') }}
                                <span>{{ __('Coupons And Discount') }}</span>
                            </a>
                        </li>
                        <li class="nav-item nav-select {{ $active_page == 'blog' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('blogs') }}">{{ __('Blog') }}
                                <span>{{ __('Blogs') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <i class="fa-solid fa-bag-shopping"></i>
            <div class="d-flex align-items-center login avtar-wrapper order-xl-3 order-4 dropdown ms-auto">

                @if (auth()->check())
                    <a class="nav-link menu-link drop-link dropdown-toggle more-drop" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar" alt="">
                    </a>
                    <ul class="dropdown-menu u-d profile-detail" aria-labelledby="offcanvasNavbarDropdown">
                        <li class="dropdown-item d-flex align-items-center">
                            <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar me-2" alt="">
                            <div>
                                <p>{{ auth()->user()->name }}</p>
                                <p class="text-muted">{{ __('Patient') }}</p>
                            </div>
                        </li>
                        <li><a class="dropdown-item " href="{{ url('user_profile') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li><a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="javascript:void(0)">{{ __('logout') }}</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <ul class="navbar-nav menubar  align-items-xl-center flex-grow-1 ">
                        <li class="nav-item dropdown ms-xl-auto">
                            <a class="nav-link drop-link menu-link dropdown-toggle more-drop" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('For Providers') }}</a>
                            <ul class="dropdown-menu u-d" aria-labelledby="offcanvasNavbarDropdown">
                                <li><a class="dropdown-item" target="_blank" href="{{ url('doctor/doctor_login') }}">{{ __('Login For Doctors') }}</a></li>
                                <li><a class="dropdown-item" href="{{ url('patient-login') }}">{{ __('Login For Patients') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
                <div class="mt-5">
                    @php
                    $languages = App\Models\Language::where('status',1)->get();
                    $icon = \App\Models\Language::where('name',session('locale'))->first();
                    if($icon)
                    {
                        $lang_image = $icon->image;
                    }
                    else
                    {
                        $lang_image = "english.png";
                    }
                    @endphp
                </div>
                <div class="dropdown">
                    <a class="nav-link menu-link drop-link dropdown-toggle more-drop" href="javascript:void(0);"  id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                        <div class="d-sm-none d-lg-inline-block"></div>
                        <img class="rounded" src="{{asset('/images/upload/'.$lang_image)}}"  style="width:40px; height:40px;">
                    </a>
                    <ul class="dropdown-menu u-d" aria-labelledby="dropdownMenuLink" style="position: absolute">
                        @foreach ($languages as $language)
                            <a href="{{ url('/change_language/'.$language->id) }}" class="dropdown-item d-flex justify-content-between">
                                <div class="dropdown-item-avatar">
                                <img width="50px" height="30px" alt="image" src="{{asset('/images/upload/'.$language->image)}}" class="rounded">
                                </div>
                                <div class="dropdown-item-desc">
                                <b>{{ $language->name }}</b>
                                </div>
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="ms-2 cart me-xl-0 me-2 ">
                    <a href="{{ url('cart') }}" class="d-flex position-relative"><i class='bx bxs-cart-alt'></i>
                        <p class="position-absolute d-flex align-items-center justify-content-center tot_cart">{{ Session::has('cart') ? count(Session::get('cart')) : 0 }}</p>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>

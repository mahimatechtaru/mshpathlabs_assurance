<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            @php
                $settings = App\Models\Setting::first();
            @endphp
            @if (auth()->user()->hasRole('super admin'))
                <a href="{{ url('/home') }}">
                    @if($settings->company_logo)
                    <img src="{{ $settings->logo }}" width="180" height="45" alt="Logo" style="object-fit: contain;">
                    @else
                    <img src="{{url('/images/upload_empty/logo_black.png')}}" width="180" height="45" alt="Logo" style="object-fit: contain;"/>
                    @endif
                </a>
            @elseif(auth()->user()->hasRole('doctor'))
                <a href="{{ url('/doctor_home') }}">
                    @if($settings->company_logo)
                    <img src="{{ $settings->logo }}" width="180" height="45" alt="Logo" style="object-fit: contain;">
                    @else
                    <img src="{{url('/images/upload_empty/logo_black.png')}}" width="180" height="45" alt="Logo" style="object-fit: contain;"/>
                    @endif
                </a>
            @elseif(auth()->user()->hasRole('pharmacy'))
                <a href="{{ url('/pharmacy_home') }}">
                    @if($settings->company_logo)
                    <img src="{{ $settings->logo }}" width="180" height="45" alt="Logo" style="object-fit: contain;">
                    @else
                    <img src="{{url('/images/upload_empty/logo_black.png')}}" width="180" height="45" alt="Logo" style="object-fit: contain;"/>
                    @endif
                </a>
            @elseif(auth()->user()->hasRole('laboratory'))
                <a href="{{ url('/pathologist_home') }}">
                    @if($settings->company_logo)
                    <img src="{{ $settings->logo }}" width="180" height="45" alt="Logo" style="object-fit: contain;">
                    @else
                    <img src="{{url('/images/upload_empty/logo_black.png')}}" width="180" height="45" alt="Logo" style="object-fit: contain;"/>
                    @endif
                </a>
            @endif
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            @if (auth()->user()->hasRole('super admin'))
            <a href="{{ url('/home') }}">
                <img src="{{$settings->favicon}}" width="50" height="50" alt="Logo">
            </a>
            @elseif(auth()->user()->hasRole('doctor'))
            <a href="{{ url('/doctor_home') }}">
                <img src="{{$settings->favicon}}" width="50" height="50" alt="Logo">
            </a>
            @elseif(auth()->user()->hasRole('pharmacy'))
            <a href="{{ url('/pharmacy_home') }}">
                <img src="{{$settings->favicon}}" width="50" height="50" alt="Logo">
            </a>
            @elseif(auth()->user()->hasRole('laboratory'))
            <a href="{{ url('/pathologist_home') }}">
                <img src="{{$settings->favicon}}" width="50" height="50" alt="Logo">
            </a>
            @endif
        </div>
        <ul class="sidebar-menu">
            @can('superadmin_dashboard')
                <li class="{{ $activePage == 'home' ? 'active' : '' }}">
                    <a href="{{ url('home') }}">
                        <i class="fas fa-home"></i>
                        <span>{{__('Dashboard')}}</span>
                    </a>
                </li>
            @endcan

            {{-- Doctor --}}
            @if (auth()->user()->hasRole('doctor'))
                @can('doctor_home')
                    <li class="{{ $activePage == 'home' ? 'active' : '' }}">
                        <a href="{{ url('doctor_home') }}">
                            <i class="fas fe fe-home"></i>
                            <span>{{__('Dashboard')}}</span>
                        </a>
                    </li>
                @endcan
            @endif


            @if (auth()->user()->hasRole('laboratory'))
                @can('laboratory_home')
                    <li class="{{ $activePage == 'pathologist' ? 'active' : '' }}">
                        <a href="{{ url('pathologist_home') }}">
                            <i class="fas fe fe-home"></i>
                            <span>{{__('Dashboard')}}</span>
                        </a>
                    </li>
                @endcan
            @endif

            @can('appointment_access')
                <li class="{{ $activePage == 'appointment' ? 'active' : '' }}">
                    <a href="{{ url('appointment') }}">
                        <i class="far fa-calendar-check"></i>
                        <span>{{__('appointment')}}</span>
                    </a>
                </li>
            @endcan

            @can('treatment_access')
                <li class="{{ $activePage == 'treatments' ? 'active' : '' }}">
                    <a href="{{ url('treatments') }}">
                        <i class="fas fa-stethoscope"></i>
                        <span>{{__('Treatments')}}</span>
                    </a>
                </li>
            @endcan

            @can('category_access')
                <li class="{{ $activePage == 'category' ? 'active' : '' }}">
                    <a href="{{ url('category') }}">
                        <i class="far fa-list-alt"></i>
                        <span>{{__('category')}}</span>
                    </a>
                </li>
            @endcan

            @can('expertise_access')
                <li class="{{ $activePage == 'expertise' ? 'active' : '' }}">
                    <a href="{{ url('expertise') }}">
                        <i class="fas fa-angle-right"></i>
                        <span>{{__('expertise')}}</span>
                    </a>
                </li>
            @endcan

            @can('medicine_category_access')
                <li class="{{ $activePage == 'medicineCategory' ? 'active' : '' }}">
                    <a href="{{ url('medicineCategory') }}">
                        <i class="fas fa-tablets"></i>
                        <span>{{__('medicine Category')}}</span>
                    </a>
                </li>
            @endcan

            @can('hospital_access')
                <li class="{{ $activePage == 'hospital' ? 'active' : '' }}">
                    <a href="{{ url('hospital') }}">
                        <i class="far fa-hospital"></i>
                        <span>{{__('hospital')}}</span>
                    </a>
                </li>
            @endcan

            @can('doctor_access')
            <li class="{{ $activePage == 'doctor' ? 'active' : '' }}">
                <a href="{{ url('doctor') }}">
                    <i class="fas fa-user-md"></i>
                    <span>{{__('doctor')}}</span>
                </a>
            </li>
            @endcan

            @can('pharmacy_access')
                <li class="{{ $activePage == 'pharmacy' ? 'active' : '' }}">
                    <a href="{{ url('pharmacy') }}">
                        <i class="fas fa-prescription-bottle"></i>
                        <span>{{__('pharmacy')}}</span>
                    </a>
                </li>
            @endcan

            @can('lab_access')
                <li class="{{ $activePage == 'lab' ? 'active' : '' }}">
                    <a href="{{ url('laboratory') }}">
                        <i class="fas fa-flask"></i>
                        <span>{{__('Laboratory')}}</span>
                    </a>
                </li>
            @endcan

            @can('pathology_category_access')
                <li class="{{ $activePage == 'pathology_category' ? 'active' : '' }}">
                    <a href="{{ url('pathology_category') }}">
                        <i class="fas fa-vials"></i>
                        <span>{{__('Pathology Category')}}</span>
                    </a>
                </li>
            @endcan

            @can('radiology_category_access')
                <li class="{{ $activePage == 'radiology_category' ? 'active' : '' }}">
                    <a href="{{ url('radiology_category') }}">
                        <i class="fab fa-xing-square"></i>
                        <span>{{__('radiology Category')}}</span>
                    </a>
                </li>
            @endcan

            @can('pathology_access')
                <li class="{{ $activePage == 'pathology' ? 'active' : '' }}">
                    <a href="{{ url('pathology') }}">
                        <i class="fas fa-vials"></i>
                        <span>{{__('pathology')}}</span>
                    </a>
                </li>
            @endcan

            @can('radiology_access')
                <li class="{{ $activePage == 'radiology' ? 'active' : '' }}">
                    <a href="{{ url('radiology') }}">
                        <i class="fas fa-x-ray"></i>
                        <span>{{__('radiology')}}</span>
                    </a>
                </li>
            @endcan

            @can('test_report')
                <li class="{{ $activePage == 'test_report' ? 'active' : '' }}">
                    <a href="{{ url('test_reports') }}">
                        <i class="fas fa-file"></i>
                        <span>{{__('Test Reports')}}</span>
                    </a>
                </li>
            @endcan

            @if (auth()->user()->hasRole('laboratory'))
                @can('lab_commission')
                <li class="{{ $activePage == 'commission' ? 'active' : '' }}">
                    <a href="{{ url('lab_commission') }}">
                        <i class="fas fa-percentage"></i>
                        <span>{{__('Lab Commission')}}</span>
                    </a>
                </li>
                @endcan

                @can('lab_timeslot')
                <li class="{{ $activePage == 'schedule' ? 'active' : '' }}">
                    <a href="{{ url('lab_timeslot') }}">
                        <i class="fas fa-hourglass-half"></i>
                        <span>{{__('Lab Timeslot')}}</span>
                    </a>
                </li>
                @endcan
            @endif

            @if(auth()->user()->can('patient_access') || auth()->user()->can('admin_user_access'))
                <li class="{{ $activePage == 'patients' ? 'active' : '' }} || {{ $activePage == 'admin_users' ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="nav-link has-dropdown">
                        <i class="fas fa-user-injured"></i>
                        <span>{{__('Users')}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('admin_user_access')
                        <li class="{{ $activePage == 'admin_users' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('admin_users') }}">{{__('Admin users')}}</a>
                        </li>
                        @endcan
                        @can('patient_access')
                        <li class="{{ $activePage == 'patients' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('patient') }}">{{__('Patient')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @can('blog_access')
                <li class="{{ $activePage == 'blog' ? 'active' : '' }}">
                    <a href="{{ url('blog') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>{{__('blog')}}</span>
                    </a>
                </li>
            @endcan

            @can('banner_access')
                <li class="{{ $activePage == 'banner' ? 'active' : '' }}">
                    <a href="{{ url('banner') }}">
                        <i class="fas fa-angle-double-right"></i>
                        <span>{{__('banner')}}</span>
                    </a>
                </li>
            @endcan

            @if (Gate::check('subscription_access') || Gate::check('subscription_history'))
                @if (auth()->user()->hasRole('doctor'))
                    @php
                        $doctor = App\Models\Doctor::where('user_id',auth()->user()->id)->first();
                    @endphp
                    @if($doctor->based_on == 'subscription')
                        <li class="{{ $activePage == 'subscription' ? 'active' : '' }} || {{ $activePage == 'subscription_history' ? 'active' : '' }}">
                            <a href="javascript:void(0)" class="nav-link has-dropdown"><i class="fas fa-file-image"></i>
                                <span>{{__('subscriptions')}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ $activePage == 'subscription' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('subscription') }}">{{__('subscription')}}</a>
                                </li>
                                <li class="{{ $activePage == 'subscription_history' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('subscription_history') }}">{{__('subscription history')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if($doctor->based_on == 'commission')
                        @can('commission_details')
                            <li class="{{ $activePage == 'commission' ? 'active' : '' }}">
                                <a href="{{ url('commission') }}">
                                    <i class="far fa-money-bill-alt"></i>
                                    <span>{{__('Commission details')}}</span>
                                </a>
                            </li>
                        @endcan
                    @endif
                @else
                    <li class="{{ $activePage == 'subscription' ? 'active' : '' }} || {{ $activePage == 'subscription_history' ? 'active' : '' }}">
                        <a href="javascript:void(0)" class="nav-link has-dropdown"><i class="fas fa-file-image"></i>
                            <span>{{__('subscriptions')}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ $activePage == 'subscription' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('subscription') }}">{{__('subscription')}}</a>
                            </li>
                            <li class="{{ $activePage == 'subscription_history' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('subscription_history') }}">{{__('subscription history')}}</a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif

            @if (Gate::check('doctor_review'))
                @if (auth()->user()->hasRole('doctor'))
                <li class="{{ $activePage == 'review' ? 'active' : '' }}">
                    <a href="{{ url('doctor_review') }}">
                        <i class="fas fa-star"></i>
                        <span>{{__('Reviews')}}</span>
                    </a>
                </li>
                @endif
            @endif

            @can('offer_access')
            <li class="{{ $activePage == 'offer' ? 'active' : '' }}">
                <a href="{{ url('offer') }}">
                    <i class="fas fa-percentage"></i>
                    <span>{{__('Offers')}}</span>
                </a>
            </li>
            @endcan

            @can('email_template_access')
            <li class="{{ $activePage == 'template' ? 'active' : '' }}">
                <a href="{{ url('notification_template') }}">
                    <i class="far fa-envelope"></i>
                    <span>{{__('Notification template')}}</span>
                </a>
            </li>
            @endcan

            @can('role_access')
            <li class="{{ $activePage == 'role' ? 'active' : '' }}">
                <a href="{{ url('role') }}">
                    <i class="fas fa-user-tag"></i>
                    <span>{{__('Role and permissions')}}</span>
                </a>
            </li>
            @endcan

            @can('language_access')
            <li class="{{ $activePage == 'language' ? 'active' : '' }}">
                <a href="{{ url('language') }}">
                    <i class="fas fa-language"></i>
                    <span>{{__('Language')}}</span>
                </a>
            </li>
            @endcan

            @can('report_access')
            <li class="{{ $activePage == 'user_report' ? 'active' : '' }} || {{ $activePage == 'doctor_report' ? 'active' : '' }}">
                <a href="javascript:void(0)" class="nav-link has-dropdown">
                    <i class="fas fa-file-alt"></i>
                    <span>{{__('Reports')}}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ $activePage == 'user_report' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('user_report') }}">{{__('User Report')}}</a>
                    </li>
                    <li class="{{ $activePage == 'doctor_report' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('doctor_report') }}">{{__('Doctor Report')}}</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('superadmin_setting')
            <li class="{{ $activePage == 'setting' ? 'active' : '' }}">
                <a href="{{ url('setting') }}">
                    <i class="fas fa-cogs"></i>
                    <span>{{__('settings')}}</span>
                </a>
            </li>
            @endcan

            {{-- Doctor --}}
            @if (auth()->user()->hasRole('doctor'))
                @can('doctor_schedule')
                <li class="{{ $activePage == 'schedule' ? 'active' : '' }}">
                    <a href="{{ url('schedule') }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>{{__('Schedule Timings')}}</span>
                    </a>
                </li>
                @endcan

                @can('zoom_setting')
                <li class="{{ $activePage == 'setting' ? 'active' : '' }}">
                    <a href="{{ url('list') }}">
                        <i class="fas fa-cog"></i>
                        <span>{{__('Zoom Setting')}}</span>
                    </a>
                </li>
                @endcan
            @endif

            {{-- Pharmacy --}}
            @if (auth()->user()->hasRole('pharmacy'))
                @can('pharmacy_dashboard')
                <li class="{{ $activePage == 'home' ? 'active' : '' }}">
                    <a href="{{ url('pharmacy_home') }}">
                        <i class="fas fe fe-home"></i>
                        <span>{{__('Dashboard')}}</span>
                    </a>
                </li>
                @endcan

                @can('medicine_access')
                <li class="{{ $activePage == 'medicine' ? 'active' : '' }}">
                    <a href="{{ url('medicines') }}">
                        <i class="fas fa-capsules"></i>
                        <span>{{__('Medicine')}}</span>
                    </a>
                </li>
                @endcan

                @can('pharmacy_purchase_medicine')
                <li class="{{ $activePage == 'purchase' ? 'active' : '' }}">
                    <a href="{{ url('purchased_medicines') }}">
                        <i class="far fa-money-bill-alt"></i>
                        <span>{{__('Medicine Orders')}}</span>
                    </a>
                </li>
                @endcan

                @can('pharmacy_schedule')
                <li class="{{ $activePage == 'pharmacy_schedule' ? 'active' : '' }}">
                    <a href="{{ url('pharmacy_schedule') }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>{{__('Schedule Timings')}}</span>
                    </a>
                </li>
                @endcan

                @can('pharmacy_commission_access')
                <li class="{{ $activePage == 'commission' ? 'active' : '' }}">
                    <a href="{{ url('pharmacyCommission') }}">
                        <i class="far fa-money-bill-alt"></i>
                        <span>{{__('Commission Details')}}</span>
                    </a>
                </li>
                @endcan
            @endif

            @can('insurer_access')
            <li class="{{ $activePage == 'insurers' ? 'active' : '' }}">
                <a href="{{ url('insurers') }}">
                    <i class='fas fa-shield-alt'></i>
                    <span>{{__('Insurers')}}</span>
                </a>
            </li>
            @endcan
        </ul>
    </aside>
</div>

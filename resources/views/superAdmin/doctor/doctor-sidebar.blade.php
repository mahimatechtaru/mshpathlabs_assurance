<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="javascript:void(0)" class="booking-doc-img">
                <img src="{{ $doctor->fullImage }}" alt="User Image">
            </a>
            <div class="profile-det-info">
                <h3>{{ $doctor->name }}</h3>

                <div class="patient-details">
                    @if (isset($doctor->expertise['name']))
                    <h5 class="mb-0">{{ $doctor->expertise['name'] }}</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li class="{{ $activeBar == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/dashboard') }}">
                        <i class="fas fa-columns"></i>
                        <span>{{__('Dashboard')}}</span>
                    </a>
                </li>
                <li class="{{ $activeBar == 'patients' ? 'active' : '' }}">
                    <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/patients') }}">
                        <i class="fas fa-user-injured"></i>
                        <span>{{__('Patients')}}</span>
                    </a>
                </li>
                <li class="{{ $activeBar == 'schedule' ? 'active' : '' }}">
                    <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/schedule') }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>{{__('Schedule Timings')}}</span>
                    </a>
                </li>
                <li class="{{ $activeBar == 'finance' ? 'active' : '' }}">
                    <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/finance') }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>{{__('finance details')}}</span>
                    </a>
                </li>
                <li class="{{ $activeBar == 'password' ? 'active' : '' }}">
                    <a href="{{ url('doctor/'.$doctor->id.'/'.Str::slug($doctor->name).'/change_password') }}">
                        <i class="fas fa-lock"></i>
                        <span>{{__('Change password')}}</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

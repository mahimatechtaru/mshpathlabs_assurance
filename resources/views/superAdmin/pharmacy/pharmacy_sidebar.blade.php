<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="{{$pharmacy->fullImage}}" class="booking-doc-img" data-fancybox="gallery2">
                <img src="{{ $pharmacy->fullImage }}" alt="User Image">
            </a>
            <div class="profile-det-info">
                <h3>{{ $pharmacy->name }}</h3>
            </div>
        </div>
    </div>

    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li class="{{ $activeBar == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('pharmacy/'.$pharmacy->id) }}">
                        <i class="fas fa-columns"></i>
                        <span>{{__('Dashboard')}}</span>
                    </a>
                </li>
                <li class="{{ $activeBar == 'medicine' ? 'active' : '' }}">
                    <a href="{{ url('medicine/'.$pharmacy->id) }}">
                        <i class="fas fa-capsules"></i>
                        <span>{{__('Medicine')}}</span>
                    </a>
                </li>
                <li class="{{ $activeBar == 'schedule' ? 'active' : '' }}">
                    <a href="{{ url('pharmacy_schedule/'.$pharmacy->id) }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>{{__('Schedule Timings')}}</span>
                    </a>
                </li>
                <li class="{{ $activeBar == 'pharmacy_commission' ? 'active' : '' }}">
                    <a href="{{ url('pharmacy_commission/'.$pharmacy->id) }}">
                        <i class="far fa-money-bill-alt"></i>
                        <span>{{__('commission')}}</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<div class="navbar-bg" data-background="{{ url('assets/img/navbar_header.jpg') }}">
<span class="mask bg-gradient-dark opacity-7"></span>
</div>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="javascript:void(0)" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
  <ul class="navbar-nav navbar-right">
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
          $lang_image = "/english.png";
        }
      @endphp
   </div>
    <li class="dropdown">
      <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <div class="d-sm-none d-lg-inline-block"></div>
        <img class="rounded" src="{{asset('/images/upload/'.$lang_image)}}"  style="width:40px; height:40px;">
      </a>
      <div class="dropdown-menu dropdown-menu-right">
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
      </div>
    </li>
    <li class="dropdown"><a href="javascript:void(0)" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <div class="d-sm-none d-lg-inline-block">{{ auth()->user()->name }}</div></a>
      <div class="dropdown-menu dropdown-menu-right">
        @if(auth()->user()->hasRole('super admin'))
        <a href="{{ url('profile') }}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> {{ __('Profile') }}
        </a>
          <a href="{{ url('setting') }}" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> {{ __('Settings') }}
          </a>
        @endif
        @if(auth()->user()->hasRole('pharmacy'))
            @can('pharmacy_profile')
              <a class="dropdown-item has-icon" href="{{ url('pharmacy_profile') }}"><i class="far fa-user"></i> {{ __('Profile') }}</a>
            @endcan
            @can('pharmacy_profile')
                <a class="dropdown-item has-icon" href="{{ url('changePassword') }}"><i class="fas fa-unlock-alt"></i> {{__('change password')}}</a>
            @endcan
        @endif
        @if (auth()->user()->hasRole('doctor'))
          @can('doctor_profile')
              <a class="dropdown-item" href="{{ url('doctor_profile') }}"><i class="far fa-user"></i> {{ __('Profile') }}</a>
          @endcan
          @can('doctor_profile')
              <a class="dropdown-item" href="{{ url('changePassword') }}"><i class="fas fa-unlock-alt"></i> {{__('change password')}}</a>
          @endcan
      @endif
      @if (auth()->user()->hasRole('laboratory'))
          <a class="dropdown-item" href="{{ url('lab_profile') }}"><i class="far fa-user"></i> {{ __('Profile') }}</a>
          <a class="dropdown-item" href="{{ url('changePassword') }}"><i class="fas fa-unlock-alt"></i> {{__('change password')}}</a>
      @endif
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
        </a>
      </div>
    </li>
  </ul>
</nav>

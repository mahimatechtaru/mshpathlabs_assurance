<!DOCTYPE html>
<html lang="en">
<head>
    <script src="{{ url('assets_admin/js/jquery.min.js')}}"></script>
    @include('layout.partials.head_admin')
</head>

<body>
    <div id="app">
        @if (Auth::check())
        {{-- @if (auth::check() && auth()->user()->hasRole('doctor') || auth::check() && auth()->user()->hasRole('super admin')) --}}
        <div class="main-wrapper">
            @if (auth()->user()->verify == 0)
                    <script>
                        var baseUrl = $('input[name="base_url"]').val();
                        var userId = '{{ auth()->user()->id }}';
                        var prefix = "{{ auth()->user()->hasRole('pharmacy') ? 'pharmacy' : (auth()->user()->hasRole('laboratory') ? 'pathologist' : 'doctor') }}";
                        var redirectUrl = `${baseUrl}/${prefix}/send_otp/${userId}`;
                        if (window.location.href !== redirectUrl) {
                            window.location.replace(redirectUrl);
                        }
                    </script>
                @else
                @include('layout.partials.navbar_admin')
                @include('layout.partials.sidebar')
            @endif
            <div class="@if (auth()->user()->verify == 0) '' @else main-content @endif">
                @if (auth()->user()->hasRole('doctor'))
                    @php
                        $doctor = App\Models\Doctor::where('user_id',auth()->user()->id)->first();
                    @endphp
                        @if($doctor->based_on == 'subscription')
                            @php
                                $subscription_status = App\Models\Doctor::where('user_id',auth()->user()->id)->first()->subscription_status;
                            @endphp
                            @if($subscription_status == 1)
                                @yield('content')
                                @yield('subscription')
                            @else
                                <script>
                                    var url =  window.location.origin+window.location.pathname;
                                    var to = url.lastIndexOf('/');
                                    to = to == -1 ? url.length : to;
                                    url2 = url.substring(0, to);
                                    var a = $('input[name="base_url"]').val()+'/subscription';
                                    if (window.location.origin + window.location.pathname != $('input[name="base_url"]').val() + '/subscription'
                                        &&
                                    url2 != $('input[name="base_url"]').val() + '/subscription_purchase'
                                    )
                                    {
                                        setTimeout(() => {
                                        Swal.fire({
                                        icon: 'info',
                                        title: 'Oops...',
                                        text: 'Your Subscription plan is Expire!',
                                        onClose: () => {
                                            window.location.replace(a);
                                            }
                                        })
                                    }, 1000);
                                    }
                                </script>
                                    @yield('subscription')
                            @endif
                        @else
                            @yield('content')
                            @yield('subscription')
                        @endif
                @elseif(Gate::check('superadmin_setting'))
                    @if (App\Models\Setting::find(1)->license_verify == 1)
                            @yield('content')
                            @yield('setting')
                    @else
                        <script>
                            var a = $('input[name=base_url]').val()+'/setting';
                            if (window.location.origin + window.location.pathname != $('input[name=base_url]').val() + '/setting')
                            {
                                setTimeout(() => {
                                    Swal.fire({
                                    icon: 'info',
                                    title: 'Oops...',
                                    text: 'Your License has been deactivated...!!',
                                    onClose: () => {
                                        window.location.replace(a);
                                        }
                                    })
                                }, 1000);
                            }
                        </script>
                        @yield('setting')
                    @endif
                @else
                    @yield('content')
                @endif
        @else
            @yield('content')
            </div>
            @endif
            @include('layout.partials.footer_admin-scripts')
        </div>
    </div>
</body>

</html>

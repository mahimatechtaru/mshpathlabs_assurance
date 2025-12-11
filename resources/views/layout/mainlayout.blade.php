<!doctype HTML>
<html>

<head>
    @php
    $setting = App\Models\Setting::first();
    @endphp
    @if (isset($title))
    <title>{{ $title }} - {{ $setting->business_name }}</title>
    @else
    <title>{{ $setting->business_name }}</title>
    @endif
    <link rel="shortcut icon" type="image/x-icon" href="{{$setting->favicon}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <link rel="stylesheet" href="{{url('assets/plugins/fancybox/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_admin/css/select2.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/datatables.min.css') }}" />
    <script type="text/javascript" src="{{ url('assets_admin/js/sweetalert2@10.js') }}"></script>

    @yield('css')
    <style>
        :root {
            --site_color: <?php echo $setting->website_color;
                            ?>;
            --site_color_hover: <?php echo $setting->website_color . '70';
                                ?>;
        }
    </style>
</head>

@if (session()->has('direction') && session()->get('direction') == 'rtl')
<link rel="stylesheet" href="{{ asset('css/rtl.css') }}">

<body dir="rtl">
    @else

    <body>
        @endif
        @include('layout.partials.navbar_website')

        @if(auth()->check())

            @if(auth()->user()->verify == 0)
            <script>
                var url =  window.location.origin+window.location.pathname;
                var to = url.lastIndexOf('/');
                to = to == -1 ? url.length : to;
                url2 = url.substring(0, to);
                var a = url2 + '/send_otp';
                console.log(a);
                if (window.location.origin + window.location.pathname != a)
                {
                    window.location.replace(a);
                }
            </script>
            @endif
        @endif
        <div class="main_content overflow-hidden">
        @if(session('error'))
            @include('superAdmin.auth.errors',['error' => session('error')])
        @endif
            @yield('content')
        </div>
        @include('layout.partials.footer')


        <script src="{{ url('assets/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('assets_admin/js/datatables.min.js') }}"></script>
        <script src="{{ url('assets_admin/js/select2.min.js')}}"></script>
        <script type="text/javascript" src="{{ url('assets/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.js"></script>
        <script src="{{ url('assets/js/custom.js') }}"></script>
        <script src="{{ url('js/app.js') }}"></script>
        @yield('js')
    </body>

</html>

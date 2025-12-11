<link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ url('assets/css/boxicons.min.css') }}">

<link rel="stylesheet" href="{{ url('assets/css/slick-theme.min.css') }}" />

<link rel="stylesheet" href="{{ url('assets/css/slick.css') }}" />

<link rel="shortcut icon" type="image/x-icon" href="{{$setting->favicon}}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/datatables.min.css') }}" />

<link rel="stylesheet" href="{{url('assets/plugins/fancybox/jquery.fancybox.min.css')}}">

<script type="text/javascript" src="{{ url('assets_admin/js/sweetalert2@10.js') }}"></script>

<link rel="stylesheet" href="{{ url('assets/css/style.css') }}">


@yield('css')

<input type="hidden" name="rtl_direction" class="rtl_direction" value="{{ session('direction') == 'rtl' ? 'true' : 'false' }}">

<style>
    :root{
        --site_color : <?php echo $setting->website_color; ?>;
        --site_color_hover : <?php echo $setting->website_color.'e8'; ?>;
    }
</style>

@if (session('direction') == 'rtl')
    <link rel="stylesheet" href="{{ url('assets/css/rtl_direction.css')}}" type="text/css">
@endif

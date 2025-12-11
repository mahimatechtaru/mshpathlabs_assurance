<meta charset="utf-8">

<title>{{ App\Models\Setting::find(1)->business_name }} | @yield('title')</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

<link rel="shortcut icon" type="image/x-icon" href="{{App\Models\Setting::find(1)->favicon}}">

<input type="hidden" name="base_url" value="{{ url('/') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" type="text/css" href="{{asset('assets_admin/css/bootstrap.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/fontawesome.css') }}">

<link rel="stylesheet" type="text/css" href="{{asset('assets_admin/css/feathericon.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets_admin/css/select2.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets_admin/css/bootstrap-datetimepicker.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{url('assets/plugins/fancybox/jquery.fancybox.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/jquery.timepicker.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/datatables.min.css') }}" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/summernote.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/flatpickr.min.css') }}">

<script type="text/javascript" src="{{ url('assets_admin/js/sweetalert2@10.js') }}"></script>

@yield('css')

<link rel="stylesheet" href="{{asset('assets_admin/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets_admin/css/components.css')}}">
<link rel="stylesheet" href="{{asset('assets_admin/css/admin_custom.css')}}">

@if (session('direction') == 'rtl')
    <link rel="stylesheet" href="{{ url('assets_admin/css/rtl_direction.css')}}" type="text/css">
@endif

@php
    $color = App\Models\Setting::first()->color;
@endphp

<style>
    :root{
        --primary_color : <?php echo $color ?>;
        --primary_color_hover : <?php echo $color.'cc' ?>;
    }
</style>

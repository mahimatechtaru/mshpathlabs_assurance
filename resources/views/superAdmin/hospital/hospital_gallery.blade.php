@extends('layout.mainlayout_admin',['activePage' => 'hospital'])

@section('css')
<link rel="stylesheet" href="{{url('assets/plugins/dropzone/dropzone.min.css')}}">
@endsection

@section('title',__('All Hospital'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('hospital Gallery'),
        'url' => url('hospital'),
        'urlTitle' => __('Hospital'),
    ])

        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif

        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ url('hospitalGallery') }}" enctype="multipart/form-data" id="mydropzone" class="dropzone myform">
                    @csrf
                    <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="upload-wrap">
                    @foreach ($galleries as $gallery)
                        <div class="upload-images">
                            <a href="{{ $gallery->fullImage }}" data-fancybox="gallery2">
                                <img src="{{ url($gallery->fullImage) }}" alt="Upload Image">
                            </a>
                            <a href="javascript:void(0);" onclick="deleteData('hospitalGallery',{{ $gallery->id }})" class="btn btn-icon btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
</section>

@endsection

@section('js')
    <script src="{{url('assets/plugins/dropzone/dropzone.min.js')}}"></script>
    <script>
        "use strict";
        var totalSteps;
        var dropzone = new Dropzone("#mydropzone", {
        });
    </script>
@endsection


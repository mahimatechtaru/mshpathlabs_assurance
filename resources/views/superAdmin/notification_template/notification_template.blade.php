@extends('layout.mainlayout_admin',['activePage' => 'template'])

@section('title',__('Notification Template'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Notification Template'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif

    <div class="section_body" style="text-transform: none !important;">
        <div class="card">
            <div class="card-body d-flex">
                <ul class="nav nav-pills w-25 flex-column">
                    @foreach ($templates as $template)
                        <li class="nav-item p-1">
                            <a class="nav-link rounded {{ $loop->iteration == 1 ? 'active' : '' }}" onclick="edit_template({{$template->id}})" href="#solid-justified-tab1" data-toggle="tab">{{ $template->title }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content m-lg-5 w-100">
                    <div class="tab-pane show active" id="solid-justified-tab1">
                        <form action="{{ url('update_template/'.$notification->id) }}" class="update_template" method="post" class="myform">
                            @csrf
                            <h5>{{ $notification->title }}</h5>
                            <div class="row mt-5">
                                <div class="col-lg-6">
                                    <label class="col-form-label">{{__('Subject')}}</label>
                                    <div class="form-group">
                                        <input type="text" id="subject" required value="{{ $notification->subject }}" name="subject" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label class="col-form-label">{{__('Title')}}</label>
                                    <div class="form-group">
                                        <input type="text" id="title" readonly value="{{ $notification->title }}" name="title" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="col-form-label">{{__('Notification content')}}</label>
                                    <div class="form-group">
                                        <textarea name="msg_content" id="msg_content" class="form-control" required cols="10" rows="5">{{ $notification->msg_content }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="col-form-label">{{__('Mail content')}}</label>
                                    <div class="form-group">
                                        <textarea name="mail_content" id="mail_content" class="summernote" required>{{ $notification->mail_content }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <input type="submit" value="{{__('submit')}}" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

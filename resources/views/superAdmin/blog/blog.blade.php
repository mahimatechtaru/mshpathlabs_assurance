@extends('layout.mainlayout_admin',['activePage' => 'blog'])

@section('css')
<style>
    .blog-content
    {
            max-height: 400px;
            overflow: hidden;
    }
</style>
@endsection

@section('title',__('All Blog'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Active Blog'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            @can('blog_add')
                <div class="p-2">
                    <a href="{{ url('blog/create') }}" class="float-right">{{ __('Add New') }}</a>
                </div>
            @endcan
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col">
                        <ul class="nav nav-tabs nav-tabs-solid">
                            <li class="nav-item">
                                <a class="nav-link active" href="blog">{{__('Active Blog')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('blog/pending-blog') }}">{{__('Pending Blog')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="d-flex flex-wrap mb-5">
                    @foreach ($blogs as $blog)
                        <div class="card card-primary0 mr-3 mb-5 mt-5" style="width: 24rem">
                                <div class="card-body">
                                    <a href="{{ $blog->fullImage }}" data-fancybox="gallery2" class="rounded-lg"><img class="img-fluid w-full" style="height: 65%;" src="{{ $blog->fullImage }}" alt="Post Image"></a>
                                    <div class="blog-content">
                                        <h6 class="blog-title mt-5">{{ $blog->title }}</h6>
                                        <hr>
                                        @if (strlen($blog->desc) > 100)
                                            {!! substr(clean($blog->desc),0,100) !!}....
                                        @else
                                            {!! clean($blog->desc) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row pt-3">
                                        <div class="col">
                                            <a href="{{ url('blog/'.$blog->id.'/edit') }}" class="text-success">
                                                <i class="far fa-edit"></i> {{__('Edit')}}
                                            </a>
                                        </div>
                                        <div class="col text-right">
                                            <a href="javascript:void(0);" class="text-danger" onclick="deleteData('blog',{{ $blog->id }})">
                                                <i class="far fa-trash-alt"></i> {{__('Delete')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

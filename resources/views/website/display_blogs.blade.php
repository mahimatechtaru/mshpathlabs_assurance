@if (count($blogs) > 0)
@if (isset($blogs['data']))
@php
$data = $blogs['data'];
@endphp
@else
@php
$data = $blogs;
@endphp
@endif
    <div class="grid grid-cols-1 sm:grid-cols-2 xmd:grid-cols-3 gap-10 xxsm:mx-5 xl:mx-0 2xl:mx-0 mb-20">
        @foreach ($data as $blog)
        <a href="{{ url('blog-details/'.$blog->id.'/'.Str::slug($blog->title)) }}">
            <div class="md:mt-5 sm:mt-11 msm:mt-11 xsm:mt-11 xxsm:mt-11 w-full">
                <img class="lg:h-60 lg:w-full bg-cover object-cover" src="{{asset($blog->fullImage)}}" alt="" />
                <div class="text-gray text-left font-medium text-xl py-2 leading-5 font-fira-sans flex">
                    @if (strlen($blog->title) > 30)
                    <div class="font-fira-sans text-primary text-base font-normal leading-5 md:text-xl">{!!
                        substr(clean($blog->title),0,45) !!}....</div>
                    @else
                    <div class="font-fira-sans text-primary text-base font-normal leading-5 md:text-xl">{!!
                        clean($blog->title) !!}</div>
                    @endif
                </div>
                <div class="leading-4 font-fira-sans font-normal text-sm text-gray text-left h-28 overflow-hidden mt-2">{{ strip_tags(html_entity_decode($blog->desc)) }}</div>
            </div>
        </a>
        @endforeach
    </div>
@endif

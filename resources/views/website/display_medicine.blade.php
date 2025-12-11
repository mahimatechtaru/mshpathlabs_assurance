@if (count($medicines) > 0)
@if (isset($medicines['data']))
@php
$data = $medicines['data'];
@endphp
@else
@php
$data = $medicines;
@endphp
@endif
@foreach ($data as $value)
<div class="bg-white-50 displayMedicine p-5 border border-white-light hover:drop-shadow-lg hover:border-none">
    <img class="lg:h-52 lg:w-full" src="{{ $value['fullImage'] }}" alt="" />
    <p class="text-slate-500 text-left font-medium text-lg text-black py-2 leading-5 font-fira-sans">{{ $value['name']
        }}</p>
    <div class="flex justify-between">
        <p class="font-fira-sans font-medium text-xl leading-6 text-primary text-left">{{ $currency }}{{
            $value['price_pr_strip'] }}</p>
        <div class="sessionCart{{$value['id']}}">
            <a href="{{ url('medicine-details/'.$value['id'].'/'.Str::slug($value['name'])) }}"
                class="cart text-primary cursor-pointer"><i class="fa-solid fa-bag-shopping"></i></a>
        </div>
    </div>
</div>
@endforeach
@endif
